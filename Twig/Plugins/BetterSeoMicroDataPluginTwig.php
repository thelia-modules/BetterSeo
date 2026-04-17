<?php

/*
 * This file is part of the Thelia package.
 * http://www.thelia.net
 *
 * (c) OpenStudio <info@thelia.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BetterSeo\Twig\Plugins;

use BetterSeo\BetterSeo;
use BetterSeo\Event\BetterSeoMicroDataEvent;
use BetterSeo\Event\BetterSeoMicroDataEvents;
use BetterSeo\Event\BetterSeoPageTitleEvent;
use BetterSeo\Event\BetterSeoStoreMicroDataEvent;
use BetterSeo\Event\BetterSeoStoreMicroDataEvents;
use BetterSeo\Model\BetterSeoQuery;
use BetterSeo\Model\Map\BetterSeoI18nTableMap;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Util\PropelModelPager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Thelia\Core\Event\Image\ImageEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Exception\TaxEngineException;
use Thelia\Model\BrandI18nQuery;
use Thelia\Model\Category;
use Thelia\Model\CategoryQuery;
use Thelia\Model\ConfigQuery;
use Thelia\Model\ContentQuery;
use Thelia\Model\CountryQuery;
use Thelia\Model\Folder;
use Thelia\Model\FolderQuery;
use Thelia\Model\Lang;
use Thelia\Model\LangQuery;
use Thelia\Model\Product;
use Thelia\Model\ProductImageQuery;
use Thelia\Model\ProductPriceQuery;
use Thelia\Model\ProductQuery;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Domain\Localization\Service\LangService;
use Thelia\Domain\Taxation\TaxEngine\TaxEngine;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BetterSeoMicroDataPluginTwig extends AbstractExtension
{
    public function __construct(private Environment $twig, private RequestStack $requestStack, private EventDispatcherInterface $dispatcher, private TaxEngine $taxEngine, private LangService $langService)
    {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('BetterSeoMicroData', [$this, 'betterSeoMicroData']),
            new TwigFunction('BetterSeoPageTitle', [$this, 'betterSeoPageTitle']),
            new TwigFunction('BetterSeoPageH1', [$this, 'betterSeoPageH1']),
        ];
    }

    public function BetterSeoPageTitle(?string $type = null, ?string $id = null): string
    {
        $lang = $this->langService->getLang();

        $defaultType = $type ?? $this->getPageType() ?? '';
        $defaultId = $id ?? $this->getPageId($defaultType);
        $defaultTitle = $this->getPageTitle($defaultType, $defaultId) ?? '';

        $pageTitleEvent = new BetterSeoPageTitleEvent($defaultTitle, $defaultType,
            $defaultId, $lang->getLocale());

        $this->dispatcher->dispatch(
            $pageTitleEvent,
            BetterSeoPageTitleEvent::BETTER_SEO_PAGE_TITLE);

        return $pageTitleEvent->getTitle() ?? '';
    }

    public function betterSeoPageH1(?string $view = null, ?string $id = null)
    {
        $request = $this->requestStack->getCurrentRequest();
        $type = $view ?? $request->get('_view');
        $objectId = $id ?? $this->getPageId($type);

        if (null === $objectId) {
            return '';
        }

        $query = BetterSeoQuery::create()
        ->filterByObjectId($objectId)
        ->filterByObjectType($type)
        ->useBetterSeoI18nQuery()
        ->filterByLocale($this->langService->getLocale())
        ->endUse()
        ->withColumn(BetterSeoI18nTableMap::H1, 'h1')
        ->findOne();

        if (null !== $query && $query->getVirtualColumn('h1')) {
            return $query->getVirtualColumn('h1');
        }

        return $this->getPageTitle($type, $objectId) ?? '';
    }

    public function betterSeoMicroData(?string $view, ?array $params)
    {
        $request = $this->requestStack->getCurrentRequest();
        $objectId = null;

        $type = $view ?? $request->get('_view');

        $lang = $this->langService->getLang();

        if (!$lang) {
            $lang = LangQuery::create()->filterByByDefault(1)->findOne();
        }
        $microdata = null;

        switch ($type) {
            case 'product':
                $objectId = $params['id'] ?? $request->get('product_id');
                $product = ProductQuery::create()->filterById($objectId)->findOne();
                $relatedProducts = null;

                if (null !== $params && \array_key_exists('related_products', $params)) {
                    $relatedProducts = \is_array($params['related_products']) ? $params['related_products'] : $this->explode($params['related_products']);
                }

                $microdata = $this->getProductMicroData($product, $lang, $relatedProducts);
                break;
            case 'category':
                $objectId = $params['id'] ?? $request->get('category_id');
                if ($objectId) {
                    $page = $params['page'] ?? $request->get('page') ?? 1;
                    $limit = $params['limit'] ?? $request->get('limit') ??
                        BetterSeo::getConfigValue(BetterSeo::BETTER_SE0_LIMIT_CONFIG_KEY);

                    $category = CategoryQuery::create()->filterById($objectId)->findOne();
                    $microdata = $this->getCategoryMicroData($category, $lang, $page, $limit);
                }
                break;
            case 'folder':
                $objectId = $params['id'] ?? $request->get('folder_id');
                if ($objectId) {
                    $folder = FolderQuery::create()->filterById($objectId)->findOne();
                    $microdata = $this->getFolderMicroData($folder, $lang);
                }
                break;
            case 'content':
                $objectId = $params['id'] ?? $request->get('content_id');
                if ($objectId) {
                    $microdata = $this->getContentMicroData($objectId, $lang);
                }
                break;
        }

        $scriptsTag = '';

        $storeMicroData = $this->getStoreMicroData();

        if ($objectId) {
            $storeEvent = new BetterSeoStoreMicroDataEvent($storeMicroData, $type,
                $objectId, $lang->getLocale());

            $this->dispatcher->dispatch(
                $storeEvent,
                BetterSeoStoreMicroDataEvents::BETTER_SEO_STORE_MICRO_DATA);

            $storeMicroData = $storeEvent->getStoreMicrodata();

            $viewEvent = new BetterSeoMicroDataEvent($microdata, $type,
                $objectId, $lang->getLocale());

            $this->dispatcher->dispatch(
                $viewEvent,
                BetterSeoMicroDataEvents::BETTER_SEO_MICRO_DATA);
            $microdata = $viewEvent->getMicrodata();
        }

        $query = BetterSeoQuery::create()
        ->filterByObjectId($objectId)
        ->filterByObjectType($type)
        ->useBetterSeoI18nQuery()
        ->filterByLocale($this->langService->getLocale())
        ->endUse()
        ->withColumn(BetterSeoI18nTableMap::NOINDEX, 'noindex')
        ->withColumn(BetterSeoI18nTableMap::NOFOLLOW, 'nofollow')
        ->withColumn(BetterSeoI18nTableMap::H1, 'h1')
        ->withColumn(BetterSeoI18nTableMap::JSON_DATA, 'json_data')
        ->findOne();

        if (null !== $query) {
            if ($query->getVirtualColumn('noindex') === 1 && $query->getVirtualColumn('nofollow') === 1) {
                $scriptsTag .= '<meta name="robots" content="noindex, nofollow">';
            } elseif ($query->getVirtualColumn('noindex') === 1) {
                $scriptsTag .= '<meta name="robots" content="noindex, follow">';
            } elseif ($query->getVirtualColumn('nofollow') === 1) {
                $scriptsTag .= '<meta name="robots" content="nofollow">';
            }
        }

        $scriptsTag .= '<script type="application/ld+json">'.json_encode($storeMicroData, \JSON_UNESCAPED_UNICODE).'</script>';
        if (null !== $microdata) {
            $scriptsTag .= '<script type="application/ld+json">'.json_encode($microdata, \JSON_UNESCAPED_UNICODE).'</script>';
        }

        if (null !== $query && $query->getVirtualColumn('json_data')) {
            $scriptsTag .= '<script type="application/ld+json">'.$query->getVirtualColumn('json_data').'</script>';
        }

        return $scriptsTag;
    }

    protected function getStoreMicroData()
    {
        $country = CountryQuery::create()->filterById(ConfigQuery::read('store_country', 64))->findOne();
        $microData = [
            '@context' => 'https://schema.org/',
            '@type' => 'Organization',
            'name' => ConfigQuery::read('store_name'),
            'description' => ConfigQuery::read('store_description'),
            'url' => ConfigQuery::read('url_site'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => ConfigQuery::read('store_address1').' '.ConfigQuery::read('store_address2').' '.ConfigQuery::read('store_address3'),
                'addressLocality' => ConfigQuery::read('store_city'),
                'addressCountry' => $country?->getIsoalpha2(),
                'postalCode' => ConfigQuery::read('store_zipcode'),
            ],
        ];

        return $microData;
    }

    protected function getPageId(string $type)
    {
        $request = $this->requestStack->getCurrentRequest();
        $objectId = null;

        switch ($type) {
            case 'product':
                $objectId = $request->get('product_id');
                break;
            case 'category':
                $objectId = $request->get('category_id');
                break;
            case 'folder':
                $objectId = $request->get('folder_id');
                break;
            case 'content':
                $objectId = $request->get('content_id');
                break;
        }

        return $objectId;
    }

    protected function getPageType()
    {
        $request = $this->requestStack->getCurrentRequest();

        return $request->get('_view');
    }

    protected function getPageTitle(?string $type = null, ?string $objectId = null)
    {
        $item = null;

        switch ($type) {
            case 'product':
                $item = ProductQuery::create()->filterById($objectId)->findOne();
                break;
            case 'category':
                $item = CategoryQuery::create()->filterById($objectId)->findOne();
                break;
            case 'folder':
                $item = FolderQuery::create()->filterById($objectId)->findOne();
                break;
            case 'content':
                $item = ContentQuery::create()->filterById($objectId)->findOne();
                break;
        }

        return $item?->getTitle() ?? ConfigQuery::read('store_name') ?? '';
    }

    protected function getProductMicroData(Product $product, Lang $lang, $relatedProducts = [])
    {
        $request = $this->requestStack->getCurrentRequest();

        $product->setLocale($lang->getLocale());
        $image = ProductImageQuery::create()->filterByProductId($product->getId())->orderByPosition()->find()->getFirst();
        $pse = ProductSaleElementsQuery::create()->filterByProductId($product->getId())->filterByIsDefault(1)->findOne();
        $psePrice = ProductPriceQuery::create()->filterByProductSaleElementsId($pse->getId())->findOne();
        $taxCountry = $this->taxEngine->getDeliveryCountry();

        try {
            $taxedPrice = $product->getTaxedPrice(
                $taxCountry,
                $psePrice->getPrice()
            );
            if ($pse->getPromo()) {
                $taxedPrice = $product->getTaxedPromoPrice(
                    $taxCountry,
                    $psePrice->getPromoPrice()
                );
            }
        } catch (TaxEngineException $e) {
            $taxedPrice = null;
        }

        $imagePath = null;

        if ($image) {
            $baseSourceFilePath = ConfigQuery::read('images_library_path');
            if ($baseSourceFilePath === null) {
                $baseSourceFilePath = THELIA_LOCAL_DIR.'media'.DS.'images';
            } else {
                $baseSourceFilePath = THELIA_ROOT.$baseSourceFilePath;
            }
            $event = new ImageEvent();
            $sourceFilePath = $baseSourceFilePath.'/product/'.$image->getFile();

            $event->setSourceFilepath($sourceFilePath);
            $event->setCacheSubdirectory('product');

            try {
                $this->dispatcher->dispatch($event, TheliaEvents::IMAGE_PROCESS);
                $imagePath = $event->getFileUrl();
            } catch (\Exception $e) {
                $imagePath = $image->getFile();
            }
        }

        $microData = [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $product->getTitle(),
            'image' => $imagePath,
            'description' => $product->getDescription(),
            'sku' => $product->getRef(),
            'offers' => [
                'url' => $product->getUrl(),
                'priceCurrency' => $request->getSession()->getCurrency()->getCode(),
                'price' => $taxedPrice,
                'itemCondition' => 'https://schema.org/NewCondition',
                'availability' => $pse->getQuantity() > 0 ? 'http://schema.org/InStock' : 'http://schema.org/OutOfStock',
            ],
        ];

        if ($pse->getEanCode()) {
            $microData['gtin13'] = $pse->getEanCode();
        }

        $brandTitle = null;

        if ($brand = $product->getBrand()) {
            $brandTitle = BrandI18nQuery::create()
                ->filterById($brand->getId())
                ->findOne()
                ->getTitle();
        }

        if ($brandTitle) {
            $microData['brand']['@type'] = 'Brand';
            $microData['brand']['name'] = $brandTitle;
        }

        if ($weight = $pse->getWeight()) {
            $microData['shipping_weight'] = $weight.' kg';
        }

        if ($relatedProducts) {
            foreach ($relatedProducts as $relatedProductId) {
                $relatedProduct = ProductQuery::create()->filterById($relatedProductId)->findOne();
                $microData['isRelatedTo'][] = $this->getProductMicroData($relatedProduct, $lang);
            }
        }

        return $microData;
    }

    protected function getCategoryMicroData(Category $category, Lang $lang, $page, $limit)
    {
        $category->setLocale($lang->getLocale());

        $products = $this->getProduct($category, $page, $limit);

        $itemListElement = [];

        $i = 1;
        foreach ($products as $product) {
            $itemListElement[] = [
                '@type' => 'ListItem',
                'position' => $i++,
                'url' => $product->getUrl(),
            ];
        }

        $microData = [
            '@context' => 'https://schema.org/',
            '@type' => 'ItemList',
            'url' => $category->getUrl(),
            'numberOfItems' => \count($products),
            'itemListElement' => $itemListElement,
        ];

        return $microData;
    }

    private function getProduct(Category $category, $page, $limit): PropelModelPager|ObjectCollection|array
    {
        if (null !== $limit) {
            return ProductQuery::create()->filterByCategory($category)->paginate($page, $limit);
        }

        return $category->getProducts();
    }

    protected function getFolderMicroData(Folder $folder, Lang $lang)
    {
        $folder->setLocale($lang->getLocale());

        $microData = [
            '@context' => 'https://schema.org/',
            '@type' => 'Guide',
            'url' => $folder->getUrl(),
            'name' => $folder->getTitle(),
            'abstract' => $folder->getChapo(),
        ];

        return $microData;
    }

    protected function getContentMicroData($contentId, Lang $lang)
    {
        $content = ContentQuery::create()->filterById($contentId)->findOne();

        if (null === $content) {
            return null;
        }

        $content->setLocale($lang->getLocale());

        $microData = [
            '@context' => 'https://schema.org/',
            '@type' => 'Article',
            'url' => $content->getUrl(),
            'name' => $content->getTitle(),
            'abstract' => $content->getChapo(),
        ];

        $defaultFoIdlder = $content->getDefaultFolderId();

        if (null !== $defaultFoIdlder) {
            $default_folder = FolderQuery::create()->findOneById($defaultFoIdlder);
            if (null !== $default_folder) {
                $default_folder->setLocale($lang->getLocale());
                $microData['isPartOf'] = [
                    'name' => $default_folder->getTitle(),
                    'url' => $default_folder->getUrl(),
                ];
            }
        }

        return $microData;
    }
}

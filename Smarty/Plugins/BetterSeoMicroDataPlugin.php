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

namespace BetterSeo\Smarty\Plugins;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Thelia\Core\Event\Image\ImageEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Exception\TaxEngineException;
use Thelia\Model\Category;
use Thelia\Model\CategoryQuery;
use Thelia\Model\ConfigQuery;
use Thelia\Model\Content;
use Thelia\Model\ContentQuery;
use Thelia\Model\Folder;
use Thelia\Model\FolderQuery;
use Thelia\Model\Lang;
use Thelia\Model\LangQuery;
use Thelia\Model\Product;
use Thelia\Model\ProductImageQuery;
use Thelia\Model\ProductPriceQuery;
use Thelia\Model\ProductQuery;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\TaxEngine\TaxEngine;
use TheliaSmarty\Template\AbstractSmartyPlugin;
use TheliaSmarty\Template\SmartyPluginDescriptor;

class BetterSeoMicroDataPlugin extends AbstractSmartyPlugin
{
    protected $request;
    protected $taxEngine;
    protected $dispatcher;

    public function __construct(RequestStack $requestStack, TaxEngine $taxEngine, EventDispatcherInterface $dispatcher)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->taxEngine = $taxEngine;
        $this->dispatcher = $dispatcher;
    }

    public function getPluginDescriptors()
    {
        return [
            new SmartyPluginDescriptor('function', 'BetterSeoMicroData', $this, 'betterSeoMicroData'),
        ];
    }

    /**
     * @param $params
     *
     * @return array|int|string
     *
     * @throws \Exception
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function betterSeoMicroData($params)
    {
        $type = $params['type'] ?? $this->request->get('_view');

        $lang = $this->request->getSession()->getLang();

        if (!$lang) {
            $lang = LangQuery::create()->filterByByDefault(1)->findOne();
        }
        $microdata = null;

        switch ($type) {
            case 'product':
                $id = $params['id'] ?? $this->request->get('product_id');
                $product = ProductQuery::create()->filterById($id)->findOne();
                $relatedProducts = null;

                if (array_key_exists('related_products', $params)){
                    $relatedProducts = \is_array($params['related_products']) ? $params['related_products'] : $this->explode($params['related_products']);
                }

                $microdata = $this->getProductMicroData($product, $lang, $relatedProducts);
                break;
            case 'category':
                $id = $params['id'] ?? $this->request->get('category_id');
                if ($id) {
                    $category = CategoryQuery::create()->filterById($id)->findOne();
                    $microdata = $this->getCategoryMicroData($category, $lang);
                }
                break;
            case 'folder':
                $id = $params['id'] ?? $this->request->get('folder_id');
                if ($id) {
                    $folder = FolderQuery::create()->filterById($id)->findOne();
                    $microdata = $this->getFolderMicroData($folder, $lang);
                }
                break;
            case 'content':
                $id = $params['id'] ?? $this->request->get('content_id');
                if ($id) {
                    $microdata = $this->getContentMicroData($id, $lang);
                }
                break;
        }

        $scriptsTag = '';

        $scriptsTag .= '<script type="application/ld+json">'.json_encode($this->getStoreMicroData(), JSON_UNESCAPED_UNICODE).'</script>';
        if (null !== $microdata) {
            $scriptsTag .= '<script type="application/ld+json">'.json_encode($microdata, JSON_UNESCAPED_UNICODE).'</script>';
        }

        return $scriptsTag;
    }

    /**
     * @return array
     */
    protected function getStoreMicroData()
    {
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
                'postalCode' => ConfigQuery::read('store_zipcode'),
            ],
        ];

        return $microData;
    }

    /**
     * @param array $relatedProducts
     *
     * @return array
     *
     * @throws \Exception
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function getProductMicroData(Product $product, Lang $lang, $relatedProducts = [])
    {
        $product->setLocale($lang->getLocale());
        $image = ProductImageQuery::create()->filterByProductId($product->getId())->orderByPosition()->find()[0];
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
                'priceCurrency' => $this->request->getSession()->getCurrency()->getCode(),
                'price' => $taxedPrice,
                'itemCondition' => 'https://schema.org/NewCondition',
                'availability' => $pse->getQuantity() > 0 ? 'http://schema.org/InStock' : 'http://schema.org/OutOfStock',
            ],
        ];

        if ($pse->getEanCode()) {
            $microData['gtin13'] = $pse->getEanCode();
        }

        if ($brand = $product->getBrand()) {
            $microData['brand']['@type'] = 'Brand';
            $microData['brand']['name'] = $brand->getTitle();
        }

        if ($relatedProducts) {
            foreach ($relatedProducts as $relatedProductId) {
                $relatedProduct = ProductQuery::create()->filterById($relatedProductId)->findOne();
                $microData['isRelatedTo'][] = $this->getProductMicroData($relatedProduct, $lang);
            }
        }

        return $microData;
    }

    /**
     * @return array
     */
    protected function getCategoryMicroData(Category $category, Lang $lang)
    {
        $category->setLocale($lang->getLocale());

        $products = $category->getProducts();

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

    /**
     * @return array
     */
    protected function getFolderMicroData(Folder $folder, Lang $lang)
    {
        $folder->setLocale($lang->getLocale());

        $microData = [
            '@context' => 'https://schema.org/',
            '@type' => 'Guide',
            'url' => $folder->getUrl(),
            "name" => $folder->getTitle(),
            "abstract" => $folder->getChapo(),
        ];


        return $microData;
    }

    /**
     * @return array
     */
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
            "name" => $content->getTitle(),
            "abstract" => $content->getChapo(),
        ];

        $defaultFoIdlder = $content->getDefaultFolderId();

        if (null !== $defaultFoIdlder) {
            $default_folder = FolderQuery::create()->findOneById($defaultFoIdlder);
            if (null !== $default_folder) {
                $default_folder->setLocale($lang->getLocale());
                $microData['isPartOf'] = [
                    'name' => $default_folder->getTitle(),
                    'url' => $default_folder->getUrl()
                ];
            }
        }

        return $microData;
    }
}

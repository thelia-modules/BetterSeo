<?php

namespace BetterSeo\Smarty\Plugins;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Thelia\Core\Event\Image\ImageEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Exception\TaxEngineException;
use Thelia\Model\Accessory;
use Thelia\Model\Base\AccessoryQuery;
use Thelia\Model\Base\ModuleQuery;
use Thelia\Model\Base\ProductImage;
use Thelia\Model\Category;
use Thelia\Model\Product;
use Thelia\Model\CategoryQuery;
use Thelia\Model\ConfigQuery;
use Thelia\Model\Lang;
use Thelia\Model\LangQuery;
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
    protected $container;

    public function __construct(Request $request, TaxEngine $taxEngine, EventDispatcher $dispatcher, ContainerInterface $container)
    {
        $this->request = $request;
        $this->taxEngine = $taxEngine;
        $this->dispatcher = $dispatcher;
        $this->container = $container;
    }

    public function getPluginDescriptors()
    {
        return [
            new SmartyPluginDescriptor('function', 'BetterSeoMicroData', $this, 'betterSeoMicroData'),
        ];
    }


    /**
     * @param $params
     * @param \Smarty_Internal_Template $smarty
     * @return string
     * @throws \Exception
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function betterSeoMicroData($params,\Smarty_Internal_Template $smarty)
    {
        $type = $params['type'] ?? $this->request->get('_view');

        $lang = $this->request->getSession()->getLang();

        if (!$lang) {
            $lang = LangQuery::create()->filterByByDefault(1)->findOne();
        }

        switch ($type) {
            case 'product':
                $id = $params['id'] ?: $this->request->get('product_id');
                $product = ProductQuery::create()->filterById($id)->findOne();
                $relatedProducts = AccessoryQuery::create()->filterByProductId($product->getId())->find();
                return json_encode($this->getProductMicroData($product, $lang, $relatedProducts));
                break;
            case 'category':
                $id = $params['id'] ?: $this->request->get('category_id');
                $inPageProduct = is_array($params['in_page_products']) ? $params['in_page_products'] : $this->explode($params['in_page_products']);
                $category = CategoryQuery::create()->filterById($id)->findOne();
                return json_encode($this->getCategoryMicroData($category, $lang, $inPageProduct));
                break;
            case 'index':
                $externalLinks = is_array($params['external_links']) ? $params['external_links'] : $this->explode($params['external_links']);
                return json_encode($this->getIndexMicroData($externalLinks));
        }
        return 'type ' . $type . ' not found';
    }

    /**
     * @param Product $product
     * @param Lang $lang
     * @param array $relatedProducts
     * @return array
     * @throws \Exception
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function getProductMicroData(Product $product, Lang $lang, $relatedProducts = [])
    {
        $product->setLocale($lang->getLocale());
        $images = ProductImageQuery::create()->filterByProductId($product->getId())->orderByPosition()->find();
        $defaultPse = ProductSaleElementsQuery::create()->filterByProductId($product->getId())->filterByIsDefault(1)->findOne();
        $psePrice = ProductPriceQuery::create()->filterByProductSaleElementsId($defaultPse->getId())->findOne();
        $taxCountry = $this->taxEngine->getDeliveryCountry();

        try {
            $taxedPrice = $product->getTaxedPrice(
                $taxCountry,
                $psePrice->getPrice()
            );
            if ($defaultPse->getPromo()) {
                $taxedPrice = $product->getTaxedPromoPrice(
                    $taxCountry,
                    $psePrice->getPromoPrice()
                );
            }
        } catch (TaxEngineException $e) {
            $taxedPrice = null;
        }

        $microData = [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $product->getTitle(),
            'description' => $product->getDescription(),
            'sku' => $product->getRef(),
            'url' => $product->getUrl(),
            'weight' => $defaultPse->getWeight() . ' kg',
            'offers' => [
                '@type' => 'Offer',
                'name' => $product->getTitle(),
                'url' => $product->getUrl(),
                'priceCurrency' => $this->request->getSession()->getCurrency()->getCode(),
                'price' => $taxedPrice,
                'itemCondition' => 'https://schema.org/NewCondition',
                'availability' => $defaultPse->getQuantity() > 0 ? 'http://schema.org/InStock' : 'http://schema.org/OutOfStock'
            ]
        ];

        /** @var ProductImage $image */
        foreach ($images as $image){

            $baseSourceFilePath = ConfigQuery::read('images_library_path');
            if ($baseSourceFilePath === null) {
                $baseSourceFilePath = THELIA_LOCAL_DIR . 'media' . DS . 'images';
            } else {
                $baseSourceFilePath = THELIA_ROOT . $baseSourceFilePath;
            }
            $event = new ImageEvent();
            $sourceFilePath = $baseSourceFilePath . '/product/' . $image->getFile();

            $event->setSourceFilepath($sourceFilePath);
            $event->setCacheSubdirectory('product');

            try {

                $this->dispatcher->dispatch(TheliaEvents::IMAGE_PROCESS, $event);
                $imagePath = $event->getFileUrl();

            } catch (\Exception $e) {
                $imagePath = $image->getFile();
            }

            $microData['image'][] = $imagePath;
        }

        if ($defaultPse->getEanCode()) {
            $microData['gtin13'] = $defaultPse->getEanCode();
        }

        if ($brand = $product->getBrand()) {
            $microData['brand']['@type'] = 'Brand';
            $microData['brand']['name'] = $brand->getTitle();
        }

        $reviews = null;
        if (null !== $isNetReviewModule = ModuleQuery::create()->filterByCode("NetReviews")->filterByActivate(1)->findOne()){
            $productReviewService = $this->container->get("netreviews.product_review.service");

            $reviews = $productReviewService->getProductReviews($product->getId(), false);

            if ($reviews['count'] > 0){
                $microData['aggregateRating'] = [
                    "@type" => "AggregateRating",
                    "bestRating" => 5,
                    "ratingCount" => $reviews['count'],
                    "ratingValue" => $reviews['rate']
                ];
            }
        }

        if (null !== $relatedProducts) {
            if (null !== $isNetReviewModule){
                $ratings = null;
                foreach ($reviews["reviews"] as $index => $review){
                    $ratings[] = [
                        "@type" => "Review",
                        "author" => $review['firstname'] . " " . $review['lastname'],
                        "datePublished" => $reviews["date"],
                        "description" => $review['message'],
                        "name" => $index,
                        "reviewRating" => [
                            "@type" => "Rating",
                            "bestRating" => 5,
                            "ratingValue" => $review["rate"],
                            "worstRating" => 1]
                    ];
                }
                $microData["review"] = $ratings;
            }

            /** @var Accessory $relatedProduct */
            foreach ($relatedProducts as $relatedProduct) {
                $relatedProduct = ProductQuery::create()->filterById($relatedProduct->getAccessory())->findOne();
                $microData['isRelatedTo'][] = $this->getProductMicroData($relatedProduct, $lang, null);
            }
        }

        return $microData;
    }

    /**
     * @param Category $category
     * @param Lang $lang
     * @param array $inPageProduct
     * @return array
     * @throws \Exception
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function getCategoryMicroData(Category $category, Lang $lang, $inPageProduct)
    {
        $category->setLocale($lang->getLocale());

        $itemListElement = [];

        foreach ($inPageProduct as $productId) {
            $product = ProductQuery::create()->filterById($productId)->findOne();
            $itemListElement[] = $this->getProductMicroData($product, $lang, null);
        }

        $microData = [
            '@context' => 'https://schema.org/',
            '@type' => 'WebPage',
            'url' => $category->getUrl(),
            'mainEntity' => [
                '@context' => 'https://schema.org/',
                '@type' => 'OfferCatalog',
                'name' => $category->getTitle(),
                'url' => $category->getUrl(),
                'numberOfItems' => count($inPageProduct),
                'itemListElement' => $itemListElement
            ]
        ];

        return $microData;
    }

    protected function getIndexMicroData($externalLinks)
    {

        $microData = [
            "@context"=> "http://schema.org",
            "@type"=> "Organization",
            "name"=> ConfigQuery::read("store_name"),
            "description"=> ConfigQuery::read("store_description"),
            "url"=> ConfigQuery::read("url_site"),
            "telephone"=> ConfigQuery::read("store_phone"),
            "address"=>[
                "@type"=> "PostalAddress",
                "addressLocality"=> ConfigQuery::read("store_city"),
                "streetAddress"=> ConfigQuery::read("store_address1"),
                "postalCode"=> ConfigQuery::read("store_zipcode")
            ],
            "sameAs"=> $externalLinks
        ];

        return $microData;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: nicolasbarbey
 * Date: 23/11/2020
 * Time: 09:29
 */

namespace BetterSeo\Smarty\Plugins;


use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Thelia\Core\Event\Image\ImageEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Exception\TaxEngineException;
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
use Thelia\Tools\URL;
use TheliaSmarty\Template\AbstractSmartyPlugin;
use TheliaSmarty\Template\SmartyPluginDescriptor;

class BetterSeoMicroDataPlugin extends AbstractSmartyPlugin
{
    protected $request;
    protected $container;
    protected $dispatcher;

    public function __construct(Request $request, Container $container, EventDispatcher $dispatcher)
    {
        $this->request = $request;
        $this->container = $container;
        $this->dispatcher = $dispatcher;
    }

    public function getPluginDescriptors()
    {
        return [
            new SmartyPluginDescriptor('function', 'BetterSeoMicroData', $this, 'betterSeoMicroData')
        ];
    }


    /**
     * @param $params
     * @return array|int|string
     * @throws \Exception
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function betterSeoMicroData($params)
    {
        $type = $params['type'];
        $id = $params['id'];

        $lang = $this->request->getSession()->getLang();

        if (!$lang) {
            $lang = LangQuery::create()->filterByByDefault(1)->findOne();
        }

        switch ($type) {
            case 'product':
                $product = ProductQuery::create()->filterById($id)->findOne();
                return json_encode($this->getProductMicroData($product, $lang));
                break;
            case 'category':
                $category = CategoryQuery::create()->filterById($id)->findOne();
                return json_encode($this->getCategoryMicroData($category, $lang));
                break;
        }
        return 'type ' . $type . ' not found';
    }

    /**
     * @param Product $product
     * @param Lang $lang
     * @param bool $getProductRelated
     * @return array
     * @throws \Exception
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function getProductMicroData(Product $product, Lang $lang, $getProductRelated = true)
    {
        $product->setLocale($lang->getLocale());
        $image = ProductImageQuery::create()->filterByProductId($product->getId())->orderByPosition()->find()[0];
        $pse = ProductSaleElementsQuery::create()->filterByProductId($product->getId())->filterByIsDefault(1)->findOne();
        $psePrice = ProductPriceQuery::create()->filterByProductSaleElementsId($pse->getId())->findOne();
        $taxCountry = $this->container->get('thelia.taxEngine')->getDeliveryCountry();

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
                'availability' => $pse->getQuantity() > 0 ? 'http://schema.org/InStock' : 'http://schema.org/OutOfStock'
            ]
        ];

        if ($pse->getEanCode()) {
            $microData['gtin13'] = $pse->getEanCode();
        }

        if ($brand = $product->getBrand()) {
            $microData['brand']['@type'] = 'Brand';
            $microData['brand']['name'] = $brand->getTitle();
        }

        if ($getProductRelated) {
            foreach ($product->getProductsRelatedByAccessory() as $productRelated) {
                $microData['isRelatedTo'][] = $this->getProductMicroData($productRelated, $lang, false);
            }
        }

        return $microData;
    }

    /**
     * @param Category $category
     * @param Lang $lang
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
                'url' => $product->getUrl()
            ];
        }

        $microData = [
            '@context' => 'https://schema.org/',
            '@type' => 'ItemList',
            'url' => $category->getUrl(),
            'numberOfItems' => count($products),
            'itemListElement' => $itemListElement
        ];

        return $microData;
    }
}
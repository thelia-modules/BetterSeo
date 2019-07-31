<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace BetterSeo;



use BetterSeo\Model\SeoNoindex;
use BetterSeo\Model\SeoNoindexQuery;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Install\Database;
use Thelia\Model\Brand;
use Thelia\Model\BrandQuery;
use Thelia\Model\Category;
use Thelia\Model\CategoryQuery;
use Thelia\Model\Content;
use Thelia\Model\ContentQuery;
use Thelia\Model\Folder;
use Thelia\Model\FolderQuery;
use Thelia\Model\Product;
use Thelia\Model\ProductQuery;
use Thelia\Module\BaseModule;

class BetterSeo extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'betterseo.bo.default';

    /**
     * @param ConnectionInterface|null $con
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function postActivation(ConnectionInterface $con = null)
    {
        try{
           SeoNoindexQuery::create()->findOne();
        }catch(\Exception $e){
            $database = new Database($con);
            $database->insertSql(null,[__DIR__ . "/Config/thelia.sql"]);

            $products = ProductQuery::create()->find();
            /** @var Product $product */
            foreach ($products as $product){
                $seoObject = new SeoNoindex();
                $seoObject
                    ->setObjectType("product")
                    ->setObjectId($product->getId())
                    ->setNoindex(0)
                    ->setCanonicalField(null)
                    ->save();
            }
            $categories = CategoryQuery::create()->find();
            /** @var Category $category */
            foreach ($categories as $category){
                $seoObject = new SeoNoindex();
                $seoObject
                    ->setObjectType("category")
                    ->setObjectId($category->getId())
                    ->setNoindex(0)
                    ->setCanonicalField(null)
                    ->save();
            }
            $brands = BrandQuery::create()->find();
            /** @var Brand $brand */
            foreach ($brands as $brand){
                $seoObject = new SeoNoindex();
                $seoObject
                    ->setObjectType("brand")
                    ->setObjectId($brand->getId())
                    ->setNoindex(0)
                    ->setCanonicalField(null)
                    ->save();
            }
            $folders = FolderQuery::create()->find();
            /** @var Folder $folder */
            foreach ($folders as $folder){
                $seoObject = new SeoNoindex();
                $seoObject
                    ->setObjectType("folder")
                    ->setObjectId($folder->getId())
                    ->setNoindex(0)
                    ->setCanonicalField(null)
                    ->save();
            }
            $contents = ContentQuery::create()->find();
            /** @var Content $content */
            foreach ($contents as $content){
                $seoObject = new SeoNoindex();
                $seoObject
                    ->setObjectType("content")
                    ->setObjectId($content->getId())
                    ->setNoindex(0)
                    ->setCanonicalField(null)
                    ->save();
            }
        }
    }
}

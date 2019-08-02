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



use BetterSeo\Model\BetterSeo as BetterSeoModel;
use BetterSeo\Model\BetterSeoQuery;
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
use Thelia\Model\Lang;
use Thelia\Model\LangQuery;
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
           BetterSeoQuery::create()->findOne();
        }catch(\Exception $e){
            $database = new Database($con);
            $database->insertSql(null,[__DIR__ . "/Config/thelia.sql"]);

            $languages = LangQuery::create()
                ->filterByActive(true)
                ->find();

            $objects = [];
            $objects['product'] = ProductQuery::create()->find();
            $objects['category'] = CategoryQuery::create()->find();
            $objects['brand'] = BrandQuery::create()->find();
            $objects['folder'] = FolderQuery::create()->find();
            $objects['content'] = ContentQuery::create()->find();

            foreach ($objects as $type => $objectArray){
                foreach ($objectArray as $object){
                    $seoObject = new BetterSeoModel();
                    $seoObject
                        ->setObjectType($type)
                        ->setObjectId($object->getId());
                    /** @var Lang $language */
                    foreach ($languages as $language) {
                        $seoObject
                            ->setLocale($language->getLocale())
                            ->setNoindex(0)
                            ->setNofollow(0)
                            ->setCanonicalField(null);
                    }
                    $seoObject->save();
                }
            }
        }
    }
}

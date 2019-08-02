<?php
/**
 * Created by PhpStorm.
 * User: nicolasbarbey
 * Date: 26/07/2019
 * Time: 09:50
 */

namespace BetterSeo\Controller;



use BetterSeo\Form\BetterSeoForm;
use BetterSeo\Model\BetterSeo;
use BetterSeo\Model\BetterSeoQuery;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Model\BrandQuery;
use Thelia\Model\CategoryQuery;
use Thelia\Model\ContentQuery;
use Thelia\Model\FolderQuery;
use Thelia\Model\Lang;
use Thelia\Model\LangQuery;
use Thelia\Model\ProductQuery;

class BetterSeoController extends BaseAdminController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function saveAction()
    {
        $form = new BetterSeoForm($this->getRequest());
        $response = null;

        $seoForm = $this->validateForm($form);

        if (null === $noindex = $seoForm->get('noindex_checkbox')->getData()){
            $noindex = 0;
        };

        if (null === $nofollow = $seoForm->get('nofollow_checkbox')->getData()){
            $nofollow = 0;
        };

        $canonical = $seoForm->get('canonical_url')->getData();
        if ($canonical !== null && $canonical[0] !== '/' && filter_var($canonical, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException('The value "' . (string) $canonical . '" is not a valid Url or Uri.');
        }
        $object_id = $this->getRequest()->get('object_id');
        $object_type = $this->getRequest()->get('object_type');

        $objectSeo = BetterSeoQuery::create()
            ->filterByObjectId($object_id)
            ->filterByObjectType($object_type)
            ->findOne();

        $lang = LangQuery::create()
            ->filterById($this->getRequest()->get('lang_id'))
            ->findOne();

        if (null === $objectSeo){
            $objectSeo = new BetterSeo();
            $objectSeo
                ->setObjectId($object_id)
                ->setObjectType($object_type);
        }
        $objectSeo
            ->setLocale($lang->getLocale())
            ->setNoindex($noindex)
            ->setNofollow($nofollow)
            ->setCanonicalField($canonical)
            ->save();

        switch ($object_type){
            case 'product':
                $nameInRoute = 'products';
                break;

            case 'category':
                $nameInRoute = 'categories';
                break;

            case 'folder':
                $nameInRoute = 'folders';
                break;

            case 'content':
                $nameInRoute = $object_type;
                break;

            case 'brand':
                $nameInRoute = $object_type;
                break;

        }
        return $this->generateRedirectFromRoute('admin.'.$nameInRoute.'.update',[] ,[$object_type.'_id' => $object_id]);

    }
}
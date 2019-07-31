<?php
/**
 * Created by PhpStorm.
 * User: nicolasbarbey
 * Date: 26/07/2019
 * Time: 09:50
 */

namespace BetterSeo\Controller;



use BetterSeo\Form\BetterSeoForm;
use BetterSeo\Model\SeoNoindex;
use BetterSeo\Model\SeoNoindexQuery;
use Thelia\Controller\Admin\BaseAdminController;

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

        $canonical = $seoForm->get('canonical_text_area')->getData();
        if ($canonical !== null && $canonical[0] !== '/' && filter_var($canonical, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException('The value "' . (string) $canonical . '" is not a valid Url or Uri.');
        }
        $object_id = $this->getRequest()->get('object_id');
        $object_type = $this->getRequest()->get('object_type');

        $objectSeo = SeoNoindexQuery::create()
            ->filterByObjectId($object_id)
            ->filterByObjectType($object_type)
            ->findOne();

        if (null === $objectSeo){
            $objectSeo = new SeoNoindex();
            $objectSeo
                ->setObjectId($object_id)
                ->setObjectType($object_type)
                ->setNoindex($noindex)
                ->setCanonicalField($canonical)
                ->save();
        }
        else{
            $objectSeo
                ->setNoindex($noindex)
                ->setCanonicalField($canonical)
                ->save();
        }

        switch ($object_type){
            case 'product':
                return $this->generateRedirectFromRoute('admin.products.update',[] ,['product_id' => $object_id]);

            case 'category':
                return $this->generateRedirectFromRoute('admin.categories.update',[] ,['category_id' => $object_id]);

            case 'folder':
                return $this->generateRedirectFromRoute('admin.folders.update',[] ,['folder_id' => $object_id]);

            case 'content':
                return $this->generateRedirectFromRoute('admin.content.update',[] ,['content_id' => $object_id]);

            case 'brand':
                return $this->generateRedirectFromRoute('admin.brand.update',[] ,['brand_id' => $object_id]);

        }
    }
}
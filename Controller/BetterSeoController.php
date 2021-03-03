<?php

namespace BetterSeo\Controller;

use BetterSeo\Form\BetterSeoForm;
use BetterSeo\Model\BetterSeo;
use BetterSeo\Model\BetterSeoQuery;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Model\LangQuery;

class BetterSeoController extends BaseAdminController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function saveAction()
    {
        $form = $this->createForm(BetterSeoForm::getName());
        $response = null;

        $seoForm = $this->validateForm($form);

        $canonical = $seoForm->get('canonical_url')->getData();
        if ($canonical !== null && $canonical[0] !== '/' && filter_var($canonical, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException('The value "' . (string) $canonical . '" is not a valid Url or Uri.');
        }
        $object_id = $this->getRequest()->get('object_id');
        $object_type = $this->getRequest()->get('object_type');

        $lang = LangQuery::create()
            ->filterById($this->getRequest()->get('lang_id'))
            ->findOne();

        if (null === $objectSeo = BetterSeoQuery::create()
                ->filterByObjectId($object_id)
                ->filterByObjectType($object_type)
                ->findOne()
        ) {
            $objectSeo = (new BetterSeo())
                ->setObjectId($object_id)
                ->setObjectType($object_type);
        }

        $objectSeo
            ->setLocale($lang->getLocale())
            ->setJsonData($seoForm->get('json_data')->getData())
            ->setNoindex(null === $seoForm->get('noindex_checkbox')->getData() ? 0 : 1)
            ->setNofollow(null === $seoForm->get('nofollow_checkbox')->getData() ? 0 : 1)
            ->setH1(null === $seoForm->get('h1')->getData() ? '' : $seoForm->get('h1')->getData())
            ->setCanonicalField($canonical);

        for ($i = 1; $i <= 5; $i++) {
            call_user_func([$objectSeo, 'setMeshUrl' . $i], $seoForm->get('mesh_url_' . $i)->getData());
            call_user_func([$objectSeo, 'setMeshText' . $i], $seoForm->get('mesh_text_' . $i)->getData());
            call_user_func([$objectSeo, 'setMesh' . $i], $seoForm->get('mesh_' . $i)->getData());
        }

        $objectSeo->save();

        static $routes = [
            'product' => 'products',
            'category' => 'categories',
            'folder' => 'folders',
            'content' => 'content',
            'brand' => 'brand'
        ];

        return $this->generateRedirectFromRoute(
            'admin.'.$routes[$object_type].'.update',
            ['current_tab' => 'seo'],
            [$object_type.'_id' => $object_id]
        );
    }
}

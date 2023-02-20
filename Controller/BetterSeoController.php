<?php

namespace BetterSeo\Controller;

use BetterSeo\Form\BetterSeoForm;
use BetterSeo\Model\BetterSeo;
use BetterSeo\Model\BetterSeoQuery;
use Symfony\Component\HttpFoundation\Request;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Model\LangQuery;
use Thelia\Tools\URL;

class BetterSeoController extends BaseAdminController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function saveAction(Request $request)
    {
        $form = $this->createForm(BetterSeoForm::getName());

        $seoForm = $this->validateForm($form);

        $object_id = $request->get('object_id');
        $object_type = $request->get('object_type');

        $lang = LangQuery::create()
            ->filterById($request->get('lang_id'))
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
            ->setH1(null === $seoForm->get('h1')->getData() ? '' : $seoForm->get('h1')->getData());

        for ($i = 1; $i <= 5; $i++) {
            call_user_func([$objectSeo, 'setMeshUrl' . $i], $seoForm->get('mesh_url_' . $i)->getData());
            call_user_func([$objectSeo, 'setMeshText' . $i], $seoForm->get('mesh_text_' . $i)->getData());
            call_user_func([$objectSeo, 'setMesh' . $i], $seoForm->get('mesh_' . $i)->getData());
        }

        $objectSeo->save();

        return $this->generateRedirect(
            URL::getInstance()->absoluteUrl(
                $request->getSession()->getReturnToUrl(),
                ['current_tab' => 'seo']
            )
        );
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: nicolasbarbey
 * Date: 25/07/2019
 * Time: 09:20
 */

namespace BetterSeo\Hook;



use BetterSeo\Model\SeoNoindexQuery;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class SeoFormHook extends BaseHook
{
    public function onTabSeoUpdateForm(HookRenderEvent $event)
    {
        $objectId = $event->getArgument('id');
        $objectType = $event->getArgument('type');

        $objectSeo = SeoNoindexQuery::create()
            ->filterByObjectId($objectId)
            ->filterByObjectType($objectType)
            ->findOne();
        $noIndex = null;
        $canonical = null;
        if (null !== $objectSeo){
            $noIndex = $objectSeo->getNoindex();
            $canonical = $objectSeo->getCanonicalField();
        }

        $event->add(
            $this->render(
                "seo-additional-fields.html",
                [
                    'object_id' => $objectId,
                    'object_type' => $objectType,
                    'noindex_val' => $noIndex,
                    'canonical_val' => $canonical
                ]
            )
        );

    }
}
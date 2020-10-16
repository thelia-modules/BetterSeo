<?php

namespace BetterSeo\Hook;


use BetterSeo\Model\BetterSeo;
use BetterSeo\Model\BetterSeoQuery;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Model\BrandQuery;
use Thelia\Model\CategoryQuery;
use Thelia\Model\ContentQuery;
use Thelia\Model\FolderQuery;
use Thelia\Model\Lang;
use Thelia\Model\LangQuery;
use Thelia\Model\ProductQuery;

class SeoFormHook extends BaseHook
{
    public function onTabSeoUpdateForm(HookRenderEvent $event)
    {
        $objectId = $event->getArgument('id');
        $objectType = $event->getArgument('type');

        $event->add(
            $this->render(
                "seo-additional-fields.html",
                [
                    'object_id' => $objectId,
                    'object_type' => $objectType,
                ]
            )
        );
    }
}
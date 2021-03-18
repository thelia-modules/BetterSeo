<?php

namespace BetterSeo\Hook;


use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Core\HttpFoundation\Request;

class MetaHook extends BaseHook
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function onMainHeadBottom(HookRenderEvent $event)
    {
        $request = $this->getRequest();

        if($view = $request->get('_view')) {

            $id = $request->get($view . '_id');

            $lang = $request->getSession()->getLang();

            if ($id == 0) {
                return;
            }

            $event->add(
                $this->render('meta_hook.html', [
                    'object_id' => $id,
                    'object_type' => $view,
                    'lang_id' => $lang->getId()
                ])
            );
        }
    }
}
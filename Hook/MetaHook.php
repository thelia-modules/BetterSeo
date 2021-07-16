<?php

namespace BetterSeo\Hook;


use Symfony\Component\HttpFoundation\RequestStack;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Core\HttpFoundation\Request;

class MetaHook extends BaseHook
{
    protected $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function onMainHeadBottom(HookRenderEvent $event)
    {
        $view = $this->request->get('_view');
        if ($view && preg_match('#^[a-zA-Z0-9\-_\.]+$#', $view)) {

            $id = $this->request->get($view . '_id');

            $lang = $this->request->getSession()->getLang();

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

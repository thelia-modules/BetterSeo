<?php

/*
 * This file is part of the Thelia package.
 * http://www.thelia.net
 *
 * (c) OpenStudio <info@thelia.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BetterSeo\Hook;

use BetterSeo\Event\BetterSeoUrlEvent;
use BetterSeo\Event\BetterSeoUrlEvents;
use Symfony\Component\DependencyInjection\Attribute\Required;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class MetaHook extends BaseHook
{
    private ?RequestStack $requestStack = null;

    #[Required]
    public function setRequestStack(RequestStack $requestStack): void
    {
        $this->requestStack = $requestStack;
    }

    public function onMainHeadBottom(HookRenderEvent $event, EventDispatcherInterface $eventDispatcher): void
    {
        $request = $this->requestStack?->getCurrentRequest();
        if ($request === null) {
            return;
        }

        $view = $request->query->get('_view') ?? $request->attributes->get('_view');
        if ($view && preg_match('#^[a-zA-Z0-9\-_\.]+$#', $view)) {
            $id = $request->query->get($view.'_id') ?? $request->request->get($view.'_id');

            $lang = $request->getSession()->getLang();

            $event->add(
                $this->render('meta_hook.html', [
                    'object_id' => $id,
                    'object_type' => $view,
                    'lang_id' => $lang->getId(),
                ])
            );
        }

        $canonicalUrlEvent = new BetterSeoUrlEvent();

        $eventDispatcher->dispatch(
            $canonicalUrlEvent,
            BetterSeoUrlEvents::GENERATE_CANONICAL,
        );

        if ($canonicalUrlEvent->getUrl()) {
            $event->add('<link rel="canonical" href="'.htmlspecialchars($canonicalUrlEvent->getUrl(), \ENT_QUOTES | \ENT_SUBSTITUTE).'">');
        }
    }
}

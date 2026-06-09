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

namespace BetterSeo\EventListeners;

use BetterSeo\Model\BetterSeoQuery;
use Sitemap\Event\SitemapEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Thelia\Core\HttpFoundation\Request;

class SeoListener implements EventSubscriberInterface
{
    /** @var Request */
    protected $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function removeHrefLang(object $event): void
    {
        if (!$event instanceof \AlternateHreflang\Event\AlternateHreflangEvent) {
            return;
        }

        $objectType = $this->request->query->get('_view') ?? $this->request->request->get('_view');
        $objectId = $this->request->query->get($objectType.'_id') ?? $this->request->request->get($objectType.'_id');

        $betterSeoObject = $this->getBetterSeoObject($objectType, $objectId);
    }

    public function checkSiteMap(SitemapEvent $event): void
    {
        $objectId = $event->getRewritingUrl()->getViewId();
        $objectType = $event->getRewritingUrl()->getView();

        $betterSeoObject = $this->getBetterSeoObject($objectType, $objectId);

        if (null !== $betterSeoObject) {
            if ($betterSeoObject->getNoindex() === 1) {
                $event->setHide(true);
            }
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        $events = [];
        if (class_exists('Sitemap\Event\SitemapEvent')) {
            $events[SitemapEvent::SITEMAP_EVENT] = ['checkSiteMap', 128];
        }
        if (class_exists('AlternateHreflang\Event\AlternateHreflangEvent')) {
            $events[\AlternateHreflang\Event\AlternateHreflangEvent::BASE_EVENT_NAME] = ['removeHrefLang', 128];
        }

        return $events;
    }

    protected function getBetterSeoObject($objectType, $objectId)
    {
        $lang = $this->request->getSession()->getLang()->getLocale();

        $betterSeoObject = BetterSeoQuery::create()
            ->filterByObjectType($objectType)
            ->filterByObjectId($objectId)
            ->findOne();
        if (null !== $betterSeoObject) {
            $betterSeoObject->setLocale($lang);
        }

        return $betterSeoObject;
    }
}

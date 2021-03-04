<?php

namespace BetterSeo\EventListeners;

use AlternateHreflang\Event\AlternateHreflangEvent;
use BetterSeo\Model\BetterSeoQuery;
use CanonicalUrl\Event\CanonicalUrlEvent;
use CanonicalUrl\Event\CanonicalUrlEvents;
use Sitemap\Event\SitemapEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Thelia\Core\HttpFoundation\Request;

class SeoListener implements EventSubscriberInterface
{
    /** @var Request  */
    protected $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }


    public function generateCanonical(CanonicalUrlEvent $event)
    {
        $objectType = $this->request->get('_view');
        $objectId = $this->request->get($objectType.'_id');

        $betterSeoObject = $this->getBetterSeoObject($objectType, $objectId);

        if (null !== $betterSeoObject){
            if (null !== $betterSeoObject->getCanonicalField()){
                $event->setUrl($betterSeoObject->getCanonicalField());
            }
        }
    }

    public function removeHrefLang(AlternateHreflangEvent $event)
    {
        $objectType = $this->request->get('_view');
        $objectId = $this->request->get($objectType.'_id');

        $betterSeoObject = $this->getBetterSeoObject($objectType, $objectId);

        if (null !== $betterSeoObject){
            if (null !== $betterSeoObject->getCanonicalField()){
                $event->setUrl(null);
            }
        }
    }

    public function checkSiteMap(SitemapEvent $event)
    {
        $objectId = $event->getRewritingUrl()->getViewId();
        $objectType = $event->getRewritingUrl()->getView();

        $betterSeoObject = $this->getBetterSeoObject($objectType, $objectId);

        if (null !== $betterSeoObject){
            if ($betterSeoObject->getNoindex() === 1){
                $event->setHide(true);
            }
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        $events = [];
        if (class_exists('Sitemap\Event\SitemapEvent')){
            $events[SitemapEvent::SITEMAP_EVENT] = ['checkSiteMap',128];
        }
        if (class_exists('AlternateHreflang\Event\AlternateHreflangEvent')){
            $events[AlternateHreflangEvent::BASE_EVENT_NAME] = ['removeHrefLang',128];
        }
        if (class_exists('CanonicalUrl\Event\CanonicalUrlEvents')){
            $events[CanonicalUrlEvents::GENERATE_CANONICAL] = ['generateCanonical', 128];
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
        if (null !== $betterSeoObject){
            $betterSeoObject->setLocale($lang);
        }

        return $betterSeoObject;
    }
}

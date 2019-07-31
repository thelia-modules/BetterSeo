<?php
/**
 * Created by PhpStorm.
 * User: nicolasbarbey
 * Date: 24/07/2019
 * Time: 15:46
 */

namespace BetterSeo\EventListeners;



use AlternateHreflang\Event\AlternateHreflangEvent;
use BetterSeo\Model\SeoNoindexQuery;
use CanonicalUrl\Event\CanonicalUrlEvent;
use CanonicalUrl\Event\CanonicalUrlEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;


class SeoListener implements EventSubscriberInterface
{
    /** @var Request  */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param CanonicalUrlEvent $event
     */
    public function generateCanonical(CanonicalUrlEvent $event)
    {
        $BetterSeoObject = $this->getBetterSeoObject();
        if (null !== $BetterSeoObject){
            if (null !== $BetterSeoObject->getCanonicalField()){
                $event->setUrl($BetterSeoObject->getCanonicalField());
            }
        }
    }

    public function removeHrefLang(AlternateHreflangEvent $event)
    {
        $BetterSeoObject = $this->getBetterSeoObject();
        if (null !== $BetterSeoObject){
            if (null !== $BetterSeoObject->getCanonicalField()){
                $event->setUrl(null);
            }
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            CanonicalUrlEvents::GENERATE_CANONICAL => ['generateCanonical', 128],
            AlternateHreflangEvent::BASE_EVENT_NAME => ['removeHrefLang',128]
        ];
    }

    protected function getBetterSeoObject()
    {
        $objectType = $this->request->get('_view');
        $objectId = null;

        switch ($objectType){
            case 'product':
                $objectId = $this->request->get('product_id');
                break;
            case 'category':
                $objectId = $this->request->get('category_id');
                break;
            case 'brand':
                $objectId = $this->request->get('brand_id');
                break;
            case 'folder':
                $objectId = $this->request->get('folder_id');
                break;
            case 'content':
                $objectId = $this->request->get('content_id');
                break;
        }

        $seoObject = SeoNoindexQuery::create()
            ->filterByObjectType($objectType)
            ->filterByObjectId($objectId)
            ->findOne();

        return $seoObject;
    }
}
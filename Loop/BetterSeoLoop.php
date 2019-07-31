<?php
/**
 * Created by PhpStorm.
 * User: nicolasbarbey
 * Date: 26/07/2019
 * Time: 15:52
 */

namespace BetterSeo\Loop;



use BetterSeo\Model\SeoNoindex;
use BetterSeo\Model\SeoNoindexQuery;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

class BetterSeoLoop extends BaseI18nLoop implements PropelSearchLoopInterface
{
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
              Argument::createIntTypeArgument('object_id'),
              Argument::createAlphaNumStringTypeArgument('object_type')
        );
    }

    public function buildModelCriteria()
    {
        $objectId = $this->getObjectId();
        $objectType = $this->getObjectType();

        $query = SeoNoindexQuery::create()
            ->filterByObjectId($objectId)
            ->filterByObjectType($objectType);

        return $query;
    }

    public function parseResults(LoopResult $loopResult)
    {
        /** @var SeoNoindex $data */
        foreach ($loopResult->getResultDataCollection() as $data){
            $loopResultRow = new LoopResultRow($data);

            $loopResultRow->set('ID', $data->getId());
            $loopResultRow->set('OBJECT_ID', $data->getObjectId());
            $loopResultRow->set('OBJECT_TYPE', $data->getObjectType());
            $loopResultRow->set('NOINDEX', $data->getNoindex());
            $loopResultRow->set('CANONICAL', $data->getCanonicalField());

            $loopResult->addRow($loopResultRow);
        }
        return $loopResult;
    }


}
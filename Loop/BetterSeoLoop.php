<?php

namespace BetterSeo\Loop;

use BetterSeo\Model\BetterSeo;
use BetterSeo\Model\BetterSeoQuery;
use BetterSeo\Model\Map\BetterSeoI18nTableMap;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Model\LangQuery;

class BetterSeoLoop extends BaseI18nLoop implements PropelSearchLoopInterface
{
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntTypeArgument('object_id'),
            Argument::createAlphaNumStringTypeArgument('object_type'),
            Argument::createIntTypeArgument('lang_id')
        );
    }

    public function buildModelCriteria()
    {

        $objectId = $this->getObjectId();
        $objectType = $this->getObjectType();
        $langId = $this->getLangId();

        $lang = LangQuery::create()
            ->filterById($langId)
            ->findOne();

        $query = BetterSeoQuery::create()
            ->filterByObjectId($objectId)
            ->filterByObjectType($objectType)
            ->useBetterSeoI18nQuery()
            ->filterByLocale($lang->getLocale())
            ->endUse()
            ->withColumn(BetterSeoI18nTableMap::NOINDEX, 'noindex')
            ->withColumn(BetterSeoI18nTableMap::NOFOLLOW, 'nofollow')
            ->withColumn(BetterSeoI18nTableMap::H1, 'h1')
            ->withColumn(BetterSeoI18nTableMap::JSON_DATA, 'json_data');

        for ($i = 1; $i <= 5; $i++) {
            $query->withColumn(constant(BetterSeoI18nTableMap::class . '::MESH_TEXT_' . $i), 'mesh_text_' . $i);
            $query->withColumn(constant(BetterSeoI18nTableMap::class . '::MESH_URL_' . $i), 'mesh_url_' . $i);
            $query->withColumn(constant(BetterSeoI18nTableMap::class . '::MESH_' . $i), 'mesh_' . $i);
        }

        return $query;
    }

    /**
     * @param LoopResult $loopResult
     * @return LoopResult
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function parseResults(LoopResult $loopResult)
    {
        /** @var BetterSeo $data */
        foreach ($loopResult->getResultDataCollection() as $data) {
            $loopResultRow = new LoopResultRow($data);

            $loopResultRow->set('ID', $data->getId());
            $loopResultRow->set('OBJECT_ID', $data->getObjectId());
            $loopResultRow->set('OBJECT_TYPE', $data->getObjectType());
            $loopResultRow->set('NOINDEX', $data->getVirtualColumn('noindex'));
            $loopResultRow->set('NOFOLLOW', $data->getVirtualColumn('nofollow'));
            $loopResultRow->set('H1', $data->getVirtualColumn('h1'));
            $loopResultRow->set('JSON_DATA', $data->getVirtualColumn('json_data'));

            for ($i = 1; $i <= 5; $i++) {
                $loopResultRow->set('MESH_TEXT_' . $i, $data->getVirtualColumn('mesh_text_' . $i));
                $loopResultRow->set('MESH_URL_' . $i, $data->getVirtualColumn('mesh_url_' . $i));
                $loopResultRow->set('MESH_' . $i, $data->getVirtualColumn('mesh_' . $i));
            }

            $loopResult->addRow($loopResultRow);
        }
        return $loopResult;
    }
}

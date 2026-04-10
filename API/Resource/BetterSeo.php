<?php

namespace BetterSeo\API\Resource;

use ApiPlatform\Metadata\Operation;
use BetterSeo\Model\BetterSeoQuery;
use BetterSeo\Model\Map\BetterSeoTableMap;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;
use Thelia\Api\Resource\AbstractTranslatableResource;
use Thelia\Api\Resource\I18nCollection;
use Thelia\Api\Resource\Product as ProductResource;
use Thelia\Api\Resource\PropelResourceInterface;
use Thelia\Api\Resource\ResourceAddonInterface;
use Thelia\Api\Resource\ResourceAddonTrait;

class BetterSeo extends AbstractTranslatableResource implements ResourceAddonInterface
{
    use ResourceAddonTrait;

    #[Groups([ProductResource::GROUP_ADMIN_READ, ProductResource::GROUP_ADMIN_WRITE, ProductResource::GROUP_FRONT_READ_SINGLE])]
    public I18nCollection $i18ns;

    #[Ignore]
    public static function getResourceParent(): string
    {
        return \Thelia\Api\Resource\Product::class;
    }

    #[Ignore]
    public static function getPropelRelatedTableMap(): ?TableMap
    {
        return new BetterSeoTableMap();
    }

    public static function getI18nResourceClass(): string
    {
        return BetterSeoI18n::class;
    }

    #[Ignore]
    public static function getObjectType(): string
    {
        return strtolower((new \ReflectionClass(static::getResourceParent()))->getShortName());
    }

    /**
     * No JOIN needed: better_seo uses a polymorphic relation (object_id/object_type),
     * not a direct Propel FK, so we load data in buildFromModel instead.
     */
    public function buildFromArray(array $data, PropelResourceInterface $abstractPropelResource): ResourceAddonInterface
    {
        if (isset($data['i18ns'])) {
            $this->setI18ns($data['i18ns']);
        }

        return $this;
    }

    public static function extendQuery(ModelCriteria $query, Operation $operation = null, array $context = []): void
    {
    }

    /**
     * @throws PropelException
     */
    public function buildFromModel(ActiveRecordInterface $activeRecord, PropelResourceInterface $abstractPropelResource): ResourceAddonInterface
    {
        $betterSeoModel = BetterSeoQuery::create()
            ->filterByObjectId($activeRecord->getId())
            ->filterByObjectType(static::getObjectType())
            ->findOne();

        if ($betterSeoModel === null) {
            return $this;
        }

        $i18nClass = static::getI18nResourceClass();
        foreach ($betterSeoModel->getBetterSeoI18ns() as $i18nModel) {
            /** @var BetterSeoI18n $i18nResource */
            $i18nResource = new $i18nClass();
            $i18nResource->setNoindex($i18nModel->getNoindex());
            $i18nResource->setNofollow($i18nModel->getNofollow());
            $i18nResource->setCanonicalField($i18nModel->getCanonicalField());
            $i18nResource->setH1($i18nModel->getH1());
            $i18nResource->setMeshText1($i18nModel->getMeshText1());
            $i18nResource->setMeshUrl1($i18nModel->getMeshUrl1());
            $i18nResource->setMeshText2($i18nModel->getMeshText2());
            $i18nResource->setMeshUrl2($i18nModel->getMeshUrl2());
            $i18nResource->setMeshText3($i18nModel->getMeshText3());
            $i18nResource->setMeshUrl3($i18nModel->getMeshUrl3());
            $i18nResource->setMesh1($i18nModel->getMesh1());
            $i18nResource->setMesh2($i18nModel->getMesh2());
            $i18nResource->setMesh3($i18nModel->getMesh3());
            $i18nResource->setMesh4($i18nModel->getMesh4());
            $i18nResource->setMesh5($i18nModel->getMesh5());
            $i18nResource->setJsonData($i18nModel->getJsonData());
            $this->i18ns->add($i18nResource, $i18nModel->getLocale());
        }

        return $this;
    }

    /**
     * @throws PropelException
     */
    public function doSave(ActiveRecordInterface $activeRecord, PropelResourceInterface $abstractPropelResource): void
    {
        $betterSeoModel = BetterSeoQuery::create()
            ->filterByObjectId($activeRecord->getId())
            ->filterByObjectType(static::getObjectType())
            ->findOneOrCreate();

        $betterSeoModel->setObjectId($activeRecord->getId());
        $betterSeoModel->setObjectType(static::getObjectType());
        $betterSeoModel->save();


        foreach ($this->i18ns as $locale => $i18nResource) {
            /* @var BetterSeoI18n $i18nResource */
            $betterSeoModel->setLocale($locale);
            $betterSeoModel->setNoindex($i18nResource->getNoindex() ?? false);
            $betterSeoModel->setNofollow($i18nResource->getNofollow() ?? false);
            $betterSeoModel->setCanonicalField($i18nResource->getCanonicalField());
            $betterSeoModel->setH1($i18nResource->getH1());
            $betterSeoModel->setMeshText1($i18nResource->getMeshText1());
            $betterSeoModel->setMeshUrl1($i18nResource->getMeshUrl1());
            $betterSeoModel->setMeshText2($i18nResource->getMeshText2());
            $betterSeoModel->setMeshUrl2($i18nResource->getMeshUrl2());
            $betterSeoModel->setMeshText3($i18nResource->getMeshText3());
            $betterSeoModel->setMeshUrl3($i18nResource->getMeshUrl3());
            $betterSeoModel->setMesh1($i18nResource->getMesh1());
            $betterSeoModel->setMesh2($i18nResource->getMesh2());
            $betterSeoModel->setMesh3($i18nResource->getMesh3());
            $betterSeoModel->setMesh4($i18nResource->getMesh4());
            $betterSeoModel->setMesh5($i18nResource->getMesh5());
            $betterSeoModel->setJsonData($i18nResource->getJsonData());
            $betterSeoModel->save();
        }
    }
}

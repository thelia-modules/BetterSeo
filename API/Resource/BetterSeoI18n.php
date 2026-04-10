<?php

namespace BetterSeo\API\Resource;

use Symfony\Component\Serializer\Annotation\Groups;
use Thelia\Api\Resource\I18n;
use Thelia\Api\Resource\Product as ProductResource;

class BetterSeoI18n extends I18n
{
    protected ?string $title = null;

    #[Groups([ProductResource::GROUP_ADMIN_READ, ProductResource::GROUP_ADMIN_WRITE, ProductResource::GROUP_FRONT_READ_SINGLE])]
    protected ?bool $noindex = false;

    #[Groups([ProductResource::GROUP_ADMIN_READ, ProductResource::GROUP_ADMIN_WRITE, ProductResource::GROUP_FRONT_READ_SINGLE])]
    protected ?bool $nofollow = false;

    #[Groups([ProductResource::GROUP_ADMIN_READ, ProductResource::GROUP_ADMIN_WRITE, ProductResource::GROUP_FRONT_READ_SINGLE])]
    protected ?string $canonicalField = null;

    #[Groups([ProductResource::GROUP_ADMIN_READ, ProductResource::GROUP_ADMIN_WRITE, ProductResource::GROUP_FRONT_READ_SINGLE])]
    protected ?string $h1 = null;

    #[Groups([ProductResource::GROUP_ADMIN_READ, ProductResource::GROUP_ADMIN_WRITE, ProductResource::GROUP_FRONT_READ_SINGLE])]
    protected ?string $meshText1 = null;

    #[Groups([ProductResource::GROUP_ADMIN_READ, ProductResource::GROUP_ADMIN_WRITE, ProductResource::GROUP_FRONT_READ_SINGLE])]
    protected ?string $meshUrl1 = null;

    #[Groups([ProductResource::GROUP_ADMIN_READ, ProductResource::GROUP_ADMIN_WRITE, ProductResource::GROUP_FRONT_READ_SINGLE])]
    protected ?string $meshText2 = null;

    #[Groups([ProductResource::GROUP_ADMIN_READ, ProductResource::GROUP_ADMIN_WRITE, ProductResource::GROUP_FRONT_READ_SINGLE])]
    protected ?string $meshUrl2 = null;

    #[Groups([ProductResource::GROUP_ADMIN_READ, ProductResource::GROUP_ADMIN_WRITE, ProductResource::GROUP_FRONT_READ_SINGLE])]
    protected ?string $meshText3 = null;

    #[Groups([ProductResource::GROUP_ADMIN_READ, ProductResource::GROUP_ADMIN_WRITE, ProductResource::GROUP_FRONT_READ_SINGLE])]
    protected ?string $meshUrl3 = null;

    #[Groups([ProductResource::GROUP_ADMIN_READ, ProductResource::GROUP_ADMIN_WRITE, ProductResource::GROUP_FRONT_READ_SINGLE])]
    protected ?string $mesh1 = null;

    #[Groups([ProductResource::GROUP_ADMIN_READ, ProductResource::GROUP_ADMIN_WRITE, ProductResource::GROUP_FRONT_READ_SINGLE])]
    protected ?string $mesh2 = null;

    #[Groups([ProductResource::GROUP_ADMIN_READ, ProductResource::GROUP_ADMIN_WRITE, ProductResource::GROUP_FRONT_READ_SINGLE])]
    protected ?string $mesh3 = null;

    #[Groups([ProductResource::GROUP_ADMIN_READ, ProductResource::GROUP_ADMIN_WRITE, ProductResource::GROUP_FRONT_READ_SINGLE])]
    protected ?string $mesh4 = null;

    #[Groups([ProductResource::GROUP_ADMIN_READ, ProductResource::GROUP_ADMIN_WRITE, ProductResource::GROUP_FRONT_READ_SINGLE])]
    protected ?string $mesh5 = null;

    #[Groups([ProductResource::GROUP_ADMIN_READ, ProductResource::GROUP_ADMIN_WRITE, ProductResource::GROUP_FRONT_READ_SINGLE])]
    protected ?string $json_data = null;

    /**
     * todo : Fix Thelia I18nConstraintValidator to allow null I18n classes without title
     */
    public function getTitle(): ?string
    {
        return 'better_seo';
    }

    public function setTitle(?string $title): BetterSeoI18n
    {
        $this->title = $title;

        return $this;
    }

    public function getMesh1(): ?string
    {
        return $this->mesh1;
    }

    public function setMesh1(?string $mesh1): BetterSeoI18n
    {
        $this->mesh1 = $mesh1;
        return $this;
    }

    public function getNoindex(): ?bool
    {
        return $this->noindex;
    }

    public function setNoindex(?bool $noindex): BetterSeoI18n
    {
        $this->noindex = $noindex;
        return $this;
    }

    public function getNofollow(): ?bool
    {
        return $this->nofollow;
    }

    public function setNofollow(?bool $nofollow): BetterSeoI18n
    {
        $this->nofollow = $nofollow;
        return $this;
    }

    public function getCanonicalField(): ?string
    {
        return $this->canonicalField;
    }

    public function setCanonicalField(?string $canonicalField): BetterSeoI18n
    {
        $this->canonicalField = $canonicalField;
        return $this;
    }

    public function getH1(): ?string
    {
        return $this->h1;
    }

    public function setH1(?string $h1): BetterSeoI18n
    {
        $this->h1 = $h1;
        return $this;
    }

    public function getMeshText1(): ?string
    {
        return $this->meshText1;
    }

    public function setMeshText1(?string $meshText1): BetterSeoI18n
    {
        $this->meshText1 = $meshText1;
        return $this;
    }

    public function getMeshUrl1(): ?string
    {
        return $this->meshUrl1;
    }

    public function setMeshUrl1(?string $meshUrl1): BetterSeoI18n
    {
        $this->meshUrl1 = $meshUrl1;
        return $this;
    }

    public function getMeshText2(): ?string
    {
        return $this->meshText2;
    }

    public function setMeshText2(?string $meshText2): BetterSeoI18n
    {
        $this->meshText2 = $meshText2;
        return $this;
    }

    public function getMeshUrl2(): ?string
    {
        return $this->meshUrl2;
    }

    public function setMeshUrl2(?string $meshUrl2): BetterSeoI18n
    {
        $this->meshUrl2 = $meshUrl2;
        return $this;
    }

    public function getMeshText3(): ?string
    {
        return $this->meshText3;
    }

    public function setMeshText3(?string $meshText3): BetterSeoI18n
    {
        $this->meshText3 = $meshText3;
        return $this;
    }

    public function getMeshUrl3(): ?string
    {
        return $this->meshUrl3;
    }

    public function setMeshUrl3(?string $meshUrl3): BetterSeoI18n
    {
        $this->meshUrl3 = $meshUrl3;
        return $this;
    }

    public function getMesh2(): ?string
    {
        return $this->mesh2;
    }

    public function setMesh2(?string $mesh2): BetterSeoI18n
    {
        $this->mesh2 = $mesh2;
        return $this;
    }

    public function getMesh3(): ?string
    {
        return $this->mesh3;
    }

    public function setMesh3(?string $mesh3): BetterSeoI18n
    {
        $this->mesh3 = $mesh3;
        return $this;
    }

    public function getMesh4(): ?string
    {
        return $this->mesh4;
    }

    public function setMesh4(?string $mesh4): BetterSeoI18n
    {
        $this->mesh4 = $mesh4;
        return $this;
    }

    public function getMesh5(): ?string
    {
        return $this->mesh5;
    }

    public function setMesh5(?string $mesh5): BetterSeoI18n
    {
        $this->mesh5 = $mesh5;
        return $this;
    }

    public function getJsonData(): ?string
    {
        return $this->json_data;
    }

    public function setJsonData(?string $json_data): BetterSeoI18n
    {
        $this->json_data = $json_data;
        return $this;
    }
}

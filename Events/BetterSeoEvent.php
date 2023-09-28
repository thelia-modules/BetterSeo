<?php

namespace BetterSeo\Events;

use Thelia\Core\Event\ActionEvent;
use Thelia\Model\Product;

class BetterSeoEvent extends ActionEvent
{
    public const BETTER_SEO_EVENT = 'thelia.module.better_seo';

    public function __construct(private array $metaDatas, private readonly string $type, private ?object $ref = null){}

    /**
     * @return array
     */
    public function getMetaDatas(): array
    {
        return $this->metaDatas;
    }

    /**
     * @param array $metaDatas
     */
    public function setMetaDatas(array $metaDatas): void
    {
        $this->metaDatas = $metaDatas;
    }

    /**
     * @return object
     */
    public function getRef(): object
    {
        return $this->ref;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}

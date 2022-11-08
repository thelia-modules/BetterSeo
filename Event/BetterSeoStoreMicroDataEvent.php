<?php

namespace BetterSeo\Event;

use Thelia\Core\Event\ActionEvent;

class BetterSeoStoreMicroDataEvent extends ActionEvent
{
    /** @var array */
    protected $storeMicrodata;
    /** @var string */
    protected $view;
    /** @var int */
    protected $view_id;
    /** @var string */
    protected $locale;

    /**
     * @param array $storeMicrodata
     * @param string $view
     * @param int $view_id
     * @param string $locale
     */
    public function __construct(array $storeMicrodata, string $view, int $view_id, string $locale)
    {
        $this->storeMicrodata = $storeMicrodata;
        $this->view = $view;
        $this->view_id = $view_id;
        $this->locale = $locale;
    }

    /**
     * @return array
     */
    public function getStoreMicrodata(): array
    {
        return $this->storeMicrodata;
    }

    /**
     * @param array $storeMicrodata
     */
    public function setStoreMicrodata(array $storeMicrodata): void
    {
        $this->storeMicrodata = $storeMicrodata;
    }

    /**
     * @return string
     */
    public function getView(): string
    {
        return $this->view;
    }

    /**
     * @param string $view
     */
    public function setView(string $view): void
    {
        $this->view = $view;
    }

    /**
     * @return int
     */
    public function getViewId(): int
    {
        return $this->view_id;
    }

    /**
     * @param int $view_id
     */
    public function setViewId(int $view_id): void
    {
        $this->view_id = $view_id;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }
}
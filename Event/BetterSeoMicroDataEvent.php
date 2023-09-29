<?php

namespace BetterSeo\Event;

use Thelia\Core\Event\ActionEvent;

class BetterSeoMicroDataEvent extends ActionEvent
{
    /** @var array */
    protected $microdata;
    /** @var string */
    protected $view;
    /** @var int */
    protected $view_id;
    /** @var string */
    protected $locale;

    /**
     * @param array $microdata
     * @param string $view
     * @param int $view_id
     * @param string $locale
     */
    public function __construct(array $microdata, string $view, int $view_id, string $locale)
    {
        $this->microdata = $microdata;
        $this->view = $view;
        $this->view_id = $view_id;
        $this->locale = $locale;
    }

    /**
     * @return array
     */
    public function getMicrodata(): array
    {
        return $this->microdata;
    }

    /**
     * @param array $microdata
     */
    public function setMicrodata(array $microdata): void
    {
        $this->microdata = $microdata;
    }

    /**
     * @return mixed
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param mixed $view
     */
    public function setView($view): void
    {
        $this->view = $view;
    }

    /**
     * @return mixed
     */
    public function getViewId()
    {
        return $this->view_id;
    }

    /**
     * @param mixed $view_id
     */
    public function setViewId($view_id): void
    {
        $this->view_id = $view_id;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     */
    public function setLocale($locale): void
    {
        $this->locale = $locale;
    }
}
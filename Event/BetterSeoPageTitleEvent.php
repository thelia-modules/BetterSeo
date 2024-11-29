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

namespace BetterSeo\Event;

use Thelia\Core\Event\ActionEvent;

class BetterSeoPageTitleEvent extends ActionEvent
{
    /** @var string */
    protected $title;
    /** @var string */
    protected $view;
    /** @var int */
    protected $view_id;
    /** @var string */
    protected $locale;

    public const BETTER_SEO_PAGE_TITLE = 'better.seo.page.title';

    public function __construct(string $title, string $view, ?int $view_id, string $locale)
    {
        $this->title = $title;
        $this->view = $view;
        $this->view_id = $view_id;
        $this->locale = $locale;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param array $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getView()
    {
        return $this->view;
    }

    public function setView($view): void
    {
        $this->view = $view;
    }

    public function getViewId()
    {
        return $this->view_id;
    }

    public function setViewId($view_id): void
    {
        $this->view_id = $view_id;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale): void
    {
        $this->locale = $locale;
    }
}

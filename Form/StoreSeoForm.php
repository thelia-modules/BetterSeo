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

namespace BetterSeo\Form;

use BetterSeo\BetterSeo;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class StoreSeoForm extends BaseForm
{
    public static function getName(): string
    {
        return 'betterseo_store_form_config';
    }

    /**
     * @return null
     */
    protected function buildForm()
    {
        $locale = $this->getRequest()->getSession()->getAdminEditionLang()->getLocale();
        $this->formBuilder
            ->add(
                'title',
                TextType::class,
                [
                    'required' => false,
                    'label' => Translator::getInstance()?->trans('Store name', [], BetterSeo::DOMAIN_NAME),
                    'data' => BetterSeo::getConfigValue('title', null, $locale),
                ]
            )
            ->add(
                'description',
                TextType::class,
                [
                    'required' => false,
                    'label' => Translator::getInstance()?->trans('Store description', [], BetterSeo::DOMAIN_NAME),
                    'data' => BetterSeo::getConfigValue('description', null, $locale),
                ]
            )
            ->add(
                'keywords',
                TextType::class,
                [
                    'required' => false,
                    'label' => Translator::getInstance()?->trans('Keywords', [], BetterSeo::DOMAIN_NAME),
                    'data' => BetterSeo::getConfigValue('keywords', null, $locale),
                ]
            )
        ;
    }
}

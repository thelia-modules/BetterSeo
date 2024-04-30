<?php

namespace BetterSeo\Form;

use BetterSeo\BetterSeo;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class ConfigurationForm extends BaseForm
{
    protected function buildForm(): void
    {
        $this->formBuilder
            ->add(
                'category_limit',
                TextType::class, [
                    'required' => false,
                    'label' => Translator::getInstance()?->trans('category limit', [], BetterSeo::DOMAIN_NAME),
                    'label_attr' => [
                        'for' => 'category_limit',
                        'help' => Translator::getInstance()?->trans("limit products load with better seo in your category page, use it for better performance", [], BetterSeo::DOMAIN_NAME),
                    ],
                    'data' => BetterSeo::getConfigValue(BetterSeo::BETTER_SE0_LIMIT_CONFIG_KEY)
                ]
            )
        ;
    }
}
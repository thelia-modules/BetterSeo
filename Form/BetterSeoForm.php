<?php

namespace BetterSeo\Form;

use BetterSeo\BetterSeo;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use Thelia\Type\JsonType;

class BetterSeoForm extends BaseForm
{
    protected function buildForm()
    {

        $form = $this->formBuilder;
        $form
            ->add(
                'noindex_checkbox',
                'integer',
                array(
                    'required' => false,
                    'label' => Translator::getInstance()->trans(
                        'noindex',
                        array(),
                        BetterSeo::DOMAIN_NAME
                    ),
                    'label_attr' => array(
                        'for' => 'noindex_checkbox'
                    )
                )
            )
            ->add(
                'nofollow_checkbox',
                'integer',
                array(
                    'required' => false,
                    'label' => Translator::getInstance()->trans(
                        'nofollow',
                        array(),
                        BetterSeo::DOMAIN_NAME
                    ),
                    'label_attr' => array(
                        'for' => 'nofollow_checkbox'
                    )
                )
            )
            ->add(
                'canonical_url',
                'url',
                array(
                    'required' => false,
                    'label' => Translator::getInstance()->trans(
                        'canonical',
                        array(),
                        BetterSeo::DOMAIN_NAME
                    ),
                    'label_attr' => array(
                        'for' => 'canonical_url'
                    )
                )
            )
            ->add(
                'h1',
                'text',
                array(
                    'required' => false,
                    'label' => Translator::getInstance()->trans(
                        'h1',
                        array(),
                        BetterSeo::DOMAIN_NAME
                    ),
                    'label_attr' => array(
                        'for' => 'h1'
                    )
                )
            )
            ->add(
                'json_data',
                TextareaType::class,
                [
                    'required' => false,
                    'label' => Translator::getInstance()->trans(
                        'JSON structured data',
                        [],
                        BetterSeo::DOMAIN_NAME
                    ),
                    'label_attr' => array(
                        'for' => 'json_data'
                    )
                ]

            );

        for ($i = 1; $i <= 5; $i++) {
            $form->add(
                'mesh_text_' . $i,
                'text',
                array(
                    'required' => false,
                    'label' => Translator::getInstance()->trans(
                        'text',
                        array(),
                        BetterSeo::DOMAIN_NAME
                    ),
                    'label_attr' => array(
                        'for' => 'mesh_text_' . $i
                    )
                )
            )
                ->add(
                    'mesh_url_' . $i,
                    'url',
                    array(
                        'required' => false,
                        'label' => Translator::getInstance()->trans(
                            'url',
                            array(),
                            BetterSeo::DOMAIN_NAME
                        ),
                        'label_attr' => array(
                            'for' => 'mesh_url_' . $i
                        )
                    )
                )
                ->add(
                    'mesh_' . $i,
                    'text',
                    array(
                        'required' => false,
                        'label' => Translator::getInstance()->trans(
                            'text',
                            array(),
                            BetterSeo::DOMAIN_NAME
                        ),
                        'label_attr' => array(
                            'for' => 'mesh_' . $i
                        )
                    )
                );
        }
    }

    public function getName()
    {
        return 'betterseo_form';
    }
}

<?php

namespace BetterSeo\Form;

use BetterSeo\BetterSeo;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

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
                    'label'=> Translator::getInstance()->trans(
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
                    'label'=> Translator::getInstance()->trans(
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

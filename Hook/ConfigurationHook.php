<?php

namespace BetterSeo\Hook;

use BetterSeo\Form\CategoryLimitForm;
use BetterSeo\Form\StoreSeoForm;
use Symfony\Component\DependencyInjection\Attribute\Required;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Form\TheliaFormFactory;
use Thelia\Core\Hook\BaseHook;

class ConfigurationHook extends BaseHook
{
    private TheliaFormFactory $formFactory;

    #[Required]
    public function setFormFactory(TheliaFormFactory $formFactory): void
    {
        $this->formFactory = $formFactory;
    }

    public function onModuleConfiguration(HookRenderEvent $event): void
    {
        $storeForm = $this->formFactory->createForm(StoreSeoForm::getName());
        $categoryForm = $this->formFactory->createForm(CategoryLimitForm::getName());

        $event->add($this->render('module_configuration.html.twig', [
            'store_form' => $storeForm->createView()->getView(),
            'category_form' => $categoryForm->createView()->getView(),
        ]));
    }

    public static function getSubscribedHooks(): array
    {
        return [
            'module.configuration' => [
                [
                    'type' => 'back',
                    'method' => 'onModuleConfiguration',
                ],
            ],
        ];
    }
}

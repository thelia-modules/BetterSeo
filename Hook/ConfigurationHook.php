<?php

namespace BetterSeo\Hook;

use BetterSeo\Form\CategoryLimitForm;
use BetterSeo\Form\StoreSeoForm;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Form\TheliaFormFactory;
use Thelia\Core\Hook\BaseHook;
use Thelia\Core\Template\Parser\ParserResolver;

class ConfigurationHook extends BaseHook
{
    public function __construct(
        private readonly TheliaFormFactory $formFactory,
        ?EventDispatcherInterface $dispatcher = null,
        ?ParserResolver $parserResolver = null,
    ) {
        parent::__construct($dispatcher, $parserResolver);
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

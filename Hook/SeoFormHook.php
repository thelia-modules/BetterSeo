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

namespace BetterSeo\Hook;

use BetterSeo\Form\BetterSeoForm;
use BetterSeo\Model\BetterSeoQuery;
use BetterSeo\Model\Map\BetterSeoI18nTableMap;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Form\TheliaFormFactory;
use Thelia\Core\Hook\BaseHook;
use Thelia\Core\Template\Parser\ParserResolver;
use Thelia\Model\LangQuery;

class SeoFormHook extends BaseHook
{
    public function __construct(
        private readonly TheliaFormFactory $formFactory,
        ?EventDispatcherInterface $dispatcher = null,
        ?ParserResolver $parserResolver = null,
    ) {
        parent::__construct($dispatcher, $parserResolver);
    }

    public function onTabSeoUpdateForm(HookRenderEvent $event): void
    {
        $objectId = $event->getArgument('id');
        $objectType = $event->getArgument('type');
        $langId = $this->getSession()->getAdminEditionLang()->getId();

        $lang = LangQuery::create()->filterById($langId)->findOne();

        $betterSeoData = [
            'noindex' => null,
            'nofollow' => null,
            'h1' => null,
            'json_data' => null,
        ];
        for ($i = 1; $i <= 5; $i++) {
            $betterSeoData['mesh_' . $i] = null;
            $betterSeoData['mesh_text_' . $i] = null;
            $betterSeoData['mesh_url_' . $i] = null;
        }

        if ($objectId && $objectType && $lang) {
            $query = BetterSeoQuery::create()
                ->filterByObjectId($objectId)
                ->filterByObjectType($objectType)
                ->useBetterSeoI18nQuery()
                    ->filterByLocale($lang->getLocale())
                ->endUse()
                ->withColumn(BetterSeoI18nTableMap::NOINDEX, 'noindex')
                ->withColumn(BetterSeoI18nTableMap::NOFOLLOW, 'nofollow')
                ->withColumn(BetterSeoI18nTableMap::H1, 'h1')
                ->withColumn(BetterSeoI18nTableMap::JSON_DATA, 'json_data');

            for ($i = 1; $i <= 5; $i++) {
                $query->withColumn(constant(BetterSeoI18nTableMap::class . '::MESH_TEXT_' . $i), 'mesh_text_' . $i);
                $query->withColumn(constant(BetterSeoI18nTableMap::class . '::MESH_URL_' . $i), 'mesh_url_' . $i);
                $query->withColumn(constant(BetterSeoI18nTableMap::class . '::MESH_' . $i), 'mesh_' . $i);
            }

            $row = $query->findOne();

            if ($row !== null) {
                $betterSeoData['noindex'] = $row->getVirtualColumn('noindex');
                $betterSeoData['nofollow'] = $row->getVirtualColumn('nofollow');
                $betterSeoData['h1'] = $row->getVirtualColumn('h1');
                $betterSeoData['json_data'] = $row->getVirtualColumn('json_data');
                for ($i = 1; $i <= 5; $i++) {
                    $betterSeoData['mesh_' . $i] = $row->getVirtualColumn('mesh_' . $i);
                    $betterSeoData['mesh_text_' . $i] = $row->getVirtualColumn('mesh_text_' . $i);
                    $betterSeoData['mesh_url_' . $i] = $row->getVirtualColumn('mesh_url_' . $i);
                }
            }
        }

        $form = $this->formFactory->createForm(BetterSeoForm::getName());

        $event->add(
            $this->render(
                'seo-additional-fields.html.twig',
                [
                    'object_id' => $objectId,
                    'object_type' => $objectType,
                    'edit_language_id' => $langId,
                    'better_seo_data' => $betterSeoData,
                    'form' => $form->createView()->getView(),
                ]
            )
        );
    }

    public static function getSubscribedHooks(): array
    {
        return [
            'tab-seo.bottom' => [
                [
                    'type' => 'back',
                    'method' => 'onTabSeoUpdateForm',
                ],
            ],
        ];
    }
}

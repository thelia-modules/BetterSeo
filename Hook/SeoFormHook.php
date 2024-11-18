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

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class SeoFormHook extends BaseHook
{
    public function onTabSeoUpdateForm(HookRenderEvent $event): void
    {
        $objectId = $event->getArgument('id');
        $objectType = $event->getArgument('type');

        $event->add(
            $this->render(
                'seo-additional-fields.html',
                [
                    'object_id' => $objectId,
                    'object_type' => $objectType,
                ]
            )
        );
    }
}

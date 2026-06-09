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

/*      Copyright (c) OpenStudio */
/*      email : dev@thelia.net */
/*      web : http://www.thelia.net */

/*      For the full copyright and license information, please view the LICENSE.txt */
/*      file that was distributed with this source code. */

namespace BetterSeo;

use Propel\Runtime\Connection\ConnectionInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use Symfony\Component\Finder\Finder;
use Thelia\Install\Database;
use Thelia\Module\BaseModule;

class BetterSeo extends BaseModule
{
    /** @var string */
    public const DOMAIN_NAME = 'betterseo';
    public const BETTER_SE0_LIMIT_CONFIG_KEY = 'betterseo_limit';
    public const SEO_CANONICAL_META_KEY = 'seo_canonical_meta';

    /**
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function postActivation(?ConnectionInterface $con = null): void
    {
        if (!self::getConfigValue('is_initialized', null)) {
            $database = new Database($con);
            $database->insertSql(null, [__DIR__.'/Config/thelia.sql']);
            self::setConfigValue('is_initialized', 1);
        }
    }

    public function update($currentVersion, $newVersion, ?ConnectionInterface $con = null): void
    {
        $sqlToExecute = [];
        $finder = new Finder();
        $sort = function (\SplFileInfo $a, \SplFileInfo $b) {
            $a = strtolower(substr($a->getRelativePathname(), 0, -4));
            $b = strtolower(substr($b->getRelativePathname(), 0, -4));

            return version_compare($a, $b);
        };

        $files = $finder->name('*.sql')
            ->in(__DIR__.'/Config/Update/')
            ->sort($sort);

        foreach ($files as $file) {
            if (version_compare($file->getFilename(), $currentVersion, '>')) {
                $sqlToExecute[$file->getFilename()] = $file->getRealPath();
            }
        }

        $database = new Database($con);

        foreach ($sqlToExecute as $version => $sql) {
            $database->insertSql(null, [$sql]);
        }
    }

    /**
     * Defines how services are loaded in your modules.
     */
    public static function configureServices(ServicesConfigurator $servicesConfigurator): void
    {
        $servicesConfigurator->load(self::getModuleCode().'\\', __DIR__)
            ->exclude([__DIR__.'/I18n/*', __DIR__.'/Config/**/*.php', __DIR__.'/Tests/*', __DIR__.'/BetterSeo.php'])
            ->autowire(true)
            ->autoconfigure(true);
    }
}

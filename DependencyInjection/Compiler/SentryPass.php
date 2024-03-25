<?php

declare(strict_types=1);

/**
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 *
 * Copyright (c) 2024 Mykhailo Shtanko fractalzombie@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE.MD
 * file that was distributed with this source code.
 */

namespace FRZB\Component\MetricsPower\DependencyInjection\Compiler;

use FRZB\Component\MetricsPower\DependencyInjection\Configuration;
use Sentry\ClientBuilder;
use Sentry\ClientInterface;
use Sentry\Options;
use Sentry\State\HubAdapter;
use Sentry\State\HubInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

final class SentryPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $config = self::getConfiguration($container);
        $isPublic = (bool) ($config['test'] ?? null);
        $hubDefinition = self::configureHub($config);

        $container
            ->setDefinition(HubAdapter::class, $hubDefinition)
            ->setPublic($isPublic)
        ;

        $container
            ->setAlias(HubInterface::class, HubAdapter::class)
        ;
    }

    public static function configureHub(array $config): Definition
    {
        $isPublic = (bool) ($config['test'] ?? null);
        $clientOptions = (new Definition(Options::class, [$config]))->setPublic($isPublic);
        $clientBuilder = (new Definition(ClientBuilder::class, [$clientOptions]))->setPublic($isPublic);
        $client = (new Definition(ClientInterface::class))
            ->setPublic($isPublic)
            ->setFactory([$clientBuilder, 'getClient'])
        ;

        return (new Definition(HubInterface::class))
            ->setFactory([HubAdapter::class, 'getInstance'])
            ->addMethodCall('bindClient', [$client])
            ->setPublic($isPublic)
        ;
    }

    private static function getConfiguration(ContainerBuilder $container): array
    {
        return (array) $container->getParameter(Configuration::METRICS_POWER_CONFIG)[Configuration::SENTRY_CONFIG];
    }
}

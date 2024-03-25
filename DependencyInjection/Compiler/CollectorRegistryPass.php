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
use Prometheus\CollectorRegistry;
use Prometheus\RegistryInterface;
use Prometheus\Storage\Adapter;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class CollectorRegistryPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $config = self::getConfiguration($container);
        $isPublic = (bool) ($config['test'] ?? null);

        $container
            ->getDefinition(CollectorRegistry::class)
            ->setPublic($isPublic)
            ->setArgument('$storageAdapter', $container->getDefinition(Adapter::class))
        ;

        $container
            ->setDefinition(RegistryInterface::class, $container->getDefinition(CollectorRegistry::class))
            ->setPublic($isPublic)
        ;
    }

    private static function getConfiguration(ContainerBuilder $container): array
    {
        return (array) $container->getParameter(Configuration::METRICS_POWER_CONFIG)[Configuration::PROMETHEUS_CONFIG];
    }
}

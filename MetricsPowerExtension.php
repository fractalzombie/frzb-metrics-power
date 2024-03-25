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

namespace FRZB\Component\MetricsPower;

use FRZB\Component\MetricsPower\DependencyInjection\Configuration;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class MetricsPowerExtension extends Extension
{
    /** @throws \Throwable */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $metricsPowerConfiguration = new Configuration();
        $metricsPowerProcessedConfiguration = $this->processConfiguration($metricsPowerConfiguration, $configs);
        $loader = (new YamlFileLoader($container, new FileLocator(__DIR__.'/Resources/config')));
        $container->setParameter(Configuration::METRICS_POWER_CONFIG, $metricsPowerProcessedConfiguration);

        $loader->load('services.yaml');
    }
}

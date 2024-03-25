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

namespace FRZB\Component\MetricsPower\DependencyInjection;

use FRZB\Component\MetricsPower\Enum\StorageType;
use Sentry\Options;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /** CONFIG */
    public const METRICS_POWER = 'metrics_power';
    public const METRICS_POWER_CONFIG = 'metrics_power.config';

    /** SENTRY */
    public const SENTRY_CONFIG = 'sentry';
    public const SENTRY_DSN = 'dsn';
    public const SENTRY_ENVIRONMENT = 'environment';

    /** PROMETHEUS */
    public const PROMETHEUS_CONFIG = 'prometheus';
    public const PROMETHEUS_STORAGE = 'storage';
    public const PROMETHEUS_REDIS = 'redis';
    public const PROMETHEUS_HANDLE_ALL_MESSAGES = 'handle_all_messages';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder(self::METRICS_POWER);
        $root = $builder->getRootNode();

        $root
            ->children()
                ->arrayNode(self::SENTRY_CONFIG)
                    ->children()
                        ->scalarNode(self::SENTRY_DSN)->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode(self::SENTRY_ENVIRONMENT)->isRequired()->defaultValue((new Options())->getEnvironment())->end()
                    ->end()
                ->end()
            ->end()
        ;

        $root
            ->children()
                ->arrayNode(self::PROMETHEUS_CONFIG)
                    ->children()
                        ->enumNode(self::PROMETHEUS_STORAGE)->isRequired()->cannotBeEmpty()->values(StorageType::values())->end()
                        ->booleanNode(self::PROMETHEUS_HANDLE_ALL_MESSAGES)->defaultTrue()->end()
                        ->arrayNode(self::PROMETHEUS_REDIS)
                            ->children()
                                ->scalarNode('host')->end()
                                ->integerNode('port')->end()
                                ->integerNode('database')->end()
                                ->floatNode('timeout')->end()
                                ->floatNode('read_timeout')->end()
                                ->booleanNode('persistent_connections')->end()
                                ->scalarNode('password')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        $root
            ->children()
                ->booleanNode('test')->defaultFalse()->end()
            ->end()
        ;

        return $builder;
    }
}

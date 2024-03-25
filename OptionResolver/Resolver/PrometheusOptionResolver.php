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

namespace FRZB\Component\MetricsPower\OptionResolver\Resolver;

use FRZB\Component\DependencyInjection\Attribute\AsService;
use FRZB\Component\DependencyInjection\Attribute\AsTagged;
use FRZB\Component\MetricsPower\Attribute\PrometheusOptions;
use FRZB\Component\MetricsPower\Exception\MetricsRegistrationException;
use FRZB\Component\MetricsPower\Helper\CounterHelper;
use Prometheus\Exception\MetricsRegistrationException as BaseMetricsRegistrationException;
use Prometheus\RegistryInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Messenger\Event\AbstractWorkerMessageEvent;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;

#[AsService, AsTagged(OptionResolverInterface::class)]
class PrometheusOptionResolver implements OptionResolverInterface
{
    public function __construct(
        #[Autowire(env: 'PROMETHEUS_NAMESPACE')]
        private readonly string $namespace,
        private readonly RegistryInterface $registry,
    ) {}

    /** @throws MetricsRegistrationException */
    public function __invoke(AbstractWorkerMessageEvent|SendMessageToTransportsEvent $event, PrometheusOptions $options): void
    {
        try {
            $this->registry
                ->getOrRegisterCounter($this->namespace, CounterHelper::makeName($options), $options->help, $options->labels)
                ->inc($options->values)
            ;
        } catch (BaseMetricsRegistrationException $e) {
            throw MetricsRegistrationException::fromThrowable($e);
        }
    }

    public static function getType(): string
    {
        return PrometheusOptions::class;
    }
}

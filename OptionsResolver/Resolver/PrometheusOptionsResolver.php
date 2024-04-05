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

namespace FRZB\Component\MetricsPower\OptionsResolver\Resolver;

use FRZB\Component\DependencyInjection\Attribute\AsService;
use FRZB\Component\DependencyInjection\Attribute\AsTagged;
use FRZB\Component\MetricsPower\Attribute\PrometheusOptions;
use FRZB\Component\MetricsPower\Exception\MetricsRegistrationException;
use FRZB\Component\MetricsPower\Helper\CounterHelper;
use FRZB\Component\MetricsPower\Logger\MetricsPowerLoggerInterface;
use Prometheus\Exception\MetricsRegistrationException as BaseMetricsRegistrationException;
use Prometheus\RegistryInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Messenger\Event\AbstractWorkerMessageEvent;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;
use Symfony\Component\Messenger\Event\WorkerMessageReceivedEvent;
use Symfony\Component\Messenger\Event\WorkerMessageRetriedEvent;

#[AsService, AsTagged(OptionsResolverInterface::class)]
class PrometheusOptionsResolver implements OptionsResolverInterface
{
    public function __construct(
        #[Autowire(env: 'PROMETHEUS_NAMESPACE')]
        private readonly string $namespace,
        private readonly RegistryInterface $registry,
        private readonly ?MetricsPowerLoggerInterface $logger = null,
    ) {}

    /** @throws MetricsRegistrationException */
    public function resolve(AbstractWorkerMessageEvent|SendMessageToTransportsEvent $event, PrometheusOptions $options): void
    {
        $postfix = match ($event::class) {
            WorkerMessageFailedEvent::class => 'failed',
            WorkerMessageHandledEvent::class => 'handled',
            WorkerMessageReceivedEvent::class => 'received',
            WorkerMessageRetriedEvent::class => 'retried',
            SendMessageToTransportsEvent::class => 'sent',
        };

        try {
            $this->registry
                ->getOrRegisterCounter($this->namespace, CounterHelper::makeName($options, postfix: $postfix), $options->help, $options->labels)
                ->inc($options->values);
        } catch (BaseMetricsRegistrationException $e) {
            throw MetricsRegistrationException::fromThrowable($e);
        } catch (\Throwable $e) {
            $this->logger?->error($event, $e);
        }
    }

    public static function getType(): string
    {
        return PrometheusOptions::class;
    }
}

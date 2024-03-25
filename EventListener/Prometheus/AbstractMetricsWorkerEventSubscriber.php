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

namespace FRZB\Component\MetricsPower\EventListener\Prometheus;

use Prometheus\Exception\MetricsRegistrationException;
use Prometheus\RegistryInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;
use Symfony\Component\Messenger\Event\WorkerMessageReceivedEvent;

abstract class AbstractMetricsWorkerEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly string $namespace,
        private readonly RegistryInterface $registry,
        private readonly LoggerInterface $logger
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            WorkerMessageReceivedEvent::class => 'onWorkerMessageReceivedEvent',
            WorkerMessageHandledEvent::class => 'onWorkerMessageHandledEvent',
            WorkerMessageFailedEvent::class => 'onWorkerMessageFailedEvent',
        ];
    }

    abstract public function onWorkerMessageReceivedEvent(WorkerMessageReceivedEvent $event): void;

    abstract public function onWorkerMessageHandledEvent(WorkerMessageHandledEvent $event): void;

    abstract public function onWorkerMessageFailedEvent(WorkerMessageFailedEvent $event): void;

    protected function incrementRegistryCounter(string $worker, string $name, string $help, array $labels, array $values): void
    {
        $counterName = str_replace('-', '_', sprintf('%s_%s', $worker, $name));

        try {
            $this->registry
                ->getOrRegisterCounter($this->namespace, $counterName, $help, $labels)
                ->inc($values)
            ;
        } catch (MetricsRegistrationException $e) {
            $this->logError($e);
        }
    }

    private function logError(MetricsRegistrationException $e): void
    {
        $this->logger->error(
            'Metrics registration failed, reason: {message}',
            ['message' => $e->getMessage(), 'trace' => $e->getTrace()]
        );
    }
}

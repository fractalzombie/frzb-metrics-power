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
use FRZB\Component\MetricsPower\Attribute\SentryOptions;
use Sentry\State\HubInterface;
use Symfony\Component\Messenger\Event\AbstractWorkerMessageEvent;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;

#[AsService, AsTagged(OptionsResolverInterface::class)]
class SentryOptionsResolver implements OptionsResolverInterface
{
    public function __construct(
        private readonly HubInterface $hub
    ) {}

    public function __invoke(AbstractWorkerMessageEvent|SendMessageToTransportsEvent $event, SentryOptions $options): void
    {
        match ($event::class) {
            WorkerMessageFailedEvent::class => $this->onWorkerMessageFailedEvent($event, $options),
            WorkerMessageHandledEvent::class => $this->onWorkerMessageHandledEvent($event, $options),
            default => null,
        };
    }

    public static function getType(): string
    {
        return SentryOptions::class;
    }

    private function onWorkerMessageFailedEvent(WorkerMessageFailedEvent $event, SentryOptions $options): void
    {
        if ($event->willRetry() && $options->waitRetry) {
            return;
        }

        $this->hub->captureException($event->getThrowable());
    }

    private function onWorkerMessageHandledEvent(WorkerMessageHandledEvent $event, SentryOptions $options): void
    {
        $options->onHandleFlush && $this->hub->getClient()?->flush();
    }
}

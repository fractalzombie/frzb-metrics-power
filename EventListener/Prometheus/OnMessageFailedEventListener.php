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

use FRZB\Component\MetricsPower\Enum\ListenerPriority;
use FRZB\Component\MetricsPower\Handler\MetricsHandlerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;

#[AsEventListener(WorkerMessageFailedEvent::class, priority: ListenerPriority::HIGHEST)]
final class OnMessageFailedEventListener
{
    public function __construct(
        private readonly MetricsHandlerInterface $handler,
    ) {}

    public function __invoke(WorkerMessageFailedEvent $event): void
    {
        $this->handler->handle($event);
    }
}

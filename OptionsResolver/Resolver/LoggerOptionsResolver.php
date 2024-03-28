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
use FRZB\Component\MetricsPower\Attribute\LoggerOptions;
use FRZB\Component\MetricsPower\Attribute\OptionsInterface;
use FRZB\Component\MetricsPower\Logger\MetricsPowerLoggerInterface;
use Symfony\Component\Messenger\Event\AbstractWorkerMessageEvent;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;

#[AsService, AsTagged(OptionsResolverInterface::class)]
class LoggerOptionsResolver
{
    public function __construct(
        private readonly MetricsPowerLoggerInterface $logger,
    ) {}

    public function __invoke(AbstractWorkerMessageEvent|SendMessageToTransportsEvent $event, OptionsInterface $options): void
    {
        match ($event::class) {
            WorkerMessageFailedEvent::class => $this->logger->error($event, $options, $event->getThrowable()),
            default => $this->logger->info($event, $options),
        };
    }

    public static function getType(): string
    {
        return LoggerOptions::class;
    }
}

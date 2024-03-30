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

namespace FRZB\Component\MetricsPower\Handler;

use FRZB\Component\DependencyInjection\Attribute\AsService;
use FRZB\Component\MetricsPower\Helper\MetricalHelper;
use FRZB\Component\MetricsPower\Logger\MetricsPowerLoggerInterface;
use FRZB\Component\MetricsPower\OptionsResolver\OptionsResolverLocatorInterface;
use Symfony\Component\Messenger\Event\AbstractWorkerMessageEvent;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;

#[AsService]
class MetricsHandler implements MetricsHandlerInterface
{
    public function __construct(
        private readonly OptionsResolverLocatorInterface $locator,
        private readonly MetricsPowerLoggerInterface $logger,
    ) {}

    public function handle(AbstractWorkerMessageEvent|SendMessageToTransportsEvent $event): void
    {
        foreach (MetricalHelper::getOptions($event->getEnvelope()->getMessage()) as $options) {
            try {
                $this->locator->get($options)->resolve($event, $options);
                $this->logger->info($event);
            } catch (\Throwable $e) {
                $this->logger->error($event, $e);
            }
        }
    }
}

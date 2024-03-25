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

namespace FRZB\Component\MetricsPower\Logger;

use FRZB\Component\DependencyInjection\Attribute\AsService;
use FRZB\Component\MetricsPower\Attribute\OptionsInterface;
use FRZB\Component\MetricsPower\Helper\ClassHelper;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Event\AbstractWorkerMessageEvent;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;

#[AsService]
class MetricsPowerLogger implements MetricsPowerLoggerInterface
{
    private const MESSAGE_INFO = '[MetricsPower] [INFO] [OPTIONS_CLASS: {option_class}] Metrics registration success for [MESSAGE_CLASS: {message_class}]';
    private const MESSAGE_ERROR = '[MetricsPower] [ERROR] [OPTIONS_CLASS: {option_class}] Metrics registration failed for [MESSAGE_CLASS: {message_class}], [REASON: {reason_message}], [OPTIONS_VALUES: {option_values}]';

    public function __construct(
        private readonly LoggerInterface $metricsPowerLogger
    ) {}

    public function logInfo(AbstractWorkerMessageEvent|SendMessageToTransportsEvent $event, OptionsInterface $option): void
    {
        $context = [
            'option_class' => ClassHelper::getShortName($option),
            'message_class' => ClassHelper::getShortName($event->getEnvelope()->getMessage()),
        ];

        $this->metricsPowerLogger->info(self::MESSAGE_INFO, $context);
    }

    public function logError(AbstractWorkerMessageEvent|SendMessageToTransportsEvent $event, OptionsInterface $option, \Throwable $e): void
    {
        $context = [
            'option_class' => ClassHelper::getShortName($option),
            'option_values' => ClassHelper::getProperties($option),
            'message_class' => ClassHelper::getShortName($event->getEnvelope()->getMessage()),
            'reason_message' => $e->getMessage(),
            'reason_trace' => $e->getTrace(),
        ];

        $this->metricsPowerLogger->error(self::MESSAGE_ERROR, $context);
    }
}

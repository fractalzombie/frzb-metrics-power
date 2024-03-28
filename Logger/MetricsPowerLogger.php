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
use Psr\Log\LoggerInterface;

#[AsService]
readonly class MetricsPowerLogger implements MetricsPowerLoggerInterface
{
    private const MESSAGE_INFO = '[MetricsPower] [INFO] [OPTIONS_CLASS: {options_class}] Metrics registration success for [MESSAGE_CLASS: {message_class}]';
    private const MESSAGE_ERROR = '[MetricsPower] [ERROR] [OPTIONS_CLASS: {options_class}] Metrics registration failed for [MESSAGE_CLASS: {message_class}] [REASON: {reason_message}] [OPTIONS_VALUES: {option_values}]';

    public function __construct(
        private ContextExtractorLocatorInterface $contextExtractorLocator,
        private LoggerInterface $logger,
    ) {}

    public function info(object $target, OptionsInterface $options): void
    {
        $context = $this->contextExtractorLocator
            ->get($target::class)
            ->extract($target, $options);

        $this->logger->info($context->message, $context->context);
    }

    public function error(object $target, OptionsInterface $options, \Throwable $exception): void
    {
        $context = $this->contextExtractorLocator
            ->get($target::class)
            ->extract($target, $options, $exception);

        $this->logger->error($context->message, $context->context);
    }
}

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
use Psr\Log\LoggerInterface;

#[AsService]
class MetricsPowerLogger implements MetricsPowerLoggerInterface
{
    public function __construct(
        private readonly ContextExtractorLocatorInterface $contextExtractorLocator,
        private readonly LoggerInterface $logger,
    ) {}

    public function info(object $target): void
    {
        $context = $this->contextExtractorLocator
            ->get($target::class)
            ->extract($target);

        $this->logger->info($context->message, $context->context);
    }

    public function error(object $target, \Throwable $exception): void
    {
        $context = $this->contextExtractorLocator
            ->get($target::class)
            ->extract($target);

        $this->logger->error($context->message, $context->context);
    }
}

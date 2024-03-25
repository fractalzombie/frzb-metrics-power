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

use FRZB\Component\DependencyInjection\Attribute\AsAlias;
use FRZB\Component\MetricsPower\Attribute\OptionsInterface;
use Symfony\Component\Messenger\Event\AbstractWorkerMessageEvent;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;

#[AsAlias(MetricsPowerLogger::class)]
interface MetricsPowerLoggerInterface
{
    public function logInfo(AbstractWorkerMessageEvent|SendMessageToTransportsEvent $event, OptionsInterface $option): void;

    public function logError(AbstractWorkerMessageEvent|SendMessageToTransportsEvent $event, OptionsInterface $option, \Throwable $e): void;
}

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

namespace FRZB\Component\MetricsPower\Logger\ContextExtractor;

use FRZB\Component\DependencyInjection\Attribute\AsService;
use FRZB\Component\DependencyInjection\Attribute\AsTagged;
use FRZB\Component\MetricsPower\Attribute\OptionsInterface;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;

/**
 * @implements ContextExtractorInterface<WorkerMessageHandledEvent, OptionsInterface>
 */
#[AsService, AsTagged(ContextExtractorInterface::class)]
final class WorkerMessageHandledEventContextExtractor extends AbstractWorkerMessageExtractor implements ContextExtractorInterface
{
    private const MESSAGE = '[MetricsPower] [INFO] [MESSAGE: Handle succeed] [OPTIONS_CLASS: {options_class}] [TARGET_CLASS: {target_class}] [MESSAGE_CLASS: {message_class}]';

    public static function getType(): string
    {
        return WorkerMessageHandledEvent::class;
    }

    protected function getMessage(): string
    {
        return self::MESSAGE;
    }
}

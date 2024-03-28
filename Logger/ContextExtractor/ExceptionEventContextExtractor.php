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
use FRZB\Component\MetricsPower\Helper\ClassHelper;
use FRZB\Component\MetricsPower\Logger\Data\Context;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

/**
 * @implements ContextExtractorInterface<ExceptionEvent, OptionsInterface>
 */
#[AsService, AsTagged(ContextExtractorInterface::class)]
class ExceptionEventContextExtractor implements ContextExtractorInterface
{
    private const MESSAGE = '[MetricsPower] [ERROR] [MESSAGE: Operation failed] [TARGET_CLASS: {target_class}] [EXCEPTION_CLASS: {exception_class}] [EXCEPTION_MESSAGE: {exception_message}]';

    public function extract(mixed $target, ?OptionsInterface $options = null, ?\Throwable $exception = null): Context
    {
        $context = [
            'target_class' => ClassHelper::getShortName($target),
        ];

        if ($exception) {
            $context += [
                'exception_class' => ClassHelper::getShortName($target->getThrowable()),
                'exception_message' => $target->getThrowable()->getMessage(),
                'exception_trace' => $target->getThrowable()->getTrace(),
            ];
        }

        return new Context(self::MESSAGE, $context);
    }

    public static function getType(): string
    {
        return ExceptionEvent::class;
    }
}

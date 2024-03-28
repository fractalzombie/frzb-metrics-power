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
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @implements ContextExtractorInterface<WorkerMessageFailedEvent, OptionsInterface>
 */
#[AsService, AsTagged(ContextExtractorInterface::class)]
final class WorkerMessageFailedEventContextExtractor implements ContextExtractorInterface
{
    private const MESSAGE = '[MetricsPower] [ERROR] [MESSAGE: Handle failed] [TARGET_CLASS: {target_class}] [OPTIONS_CLASS: {options_class}] [MESSAGE_CLASS: {message_class}] [EXCEPTION_CLASS: {exception_class}] [EXCEPTION_MESSAGE: {exception_message}] [OPTIONS_VALUES: {option_values}]';

    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {}

    public function extract(mixed $target, ?OptionsInterface $options = null, ?\Throwable $exception = null): Context
    {
        $context = [
            'target_class' => ClassHelper::getShortName($target),
        ];

        if ($options?->isSerializable()) {
            $context += ['target_values' => $this->serializer->serialize($target->getEnvelope()->getMessage(), JsonEncoder::FORMAT)];
        }

        if ($options) {
            $context += [
                'options_class' => ClassHelper::getShortName($options),
                'option_values' => ClassHelper::getProperties($options),
            ];
        }

        if ($exception) {
            $context += [
                'exception_class' => ClassHelper::getShortName($exception),
                'exception_message' => $exception->getMessage(),
                'exception_trace' => $exception->getTrace(),
            ];
        }

        return new Context(self::MESSAGE, $context);
    }

    public static function getType(): string
    {
        return WorkerMessageFailedEvent::class;
    }
}

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
use FRZB\Component\MetricsPower\Helper\ClassHelper;
use FRZB\Component\MetricsPower\Helper\MetricalHelper;
use FRZB\Component\MetricsPower\Logger\Data\LoggerContext;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[AsService, AsTagged(ContextExtractorInterface::class)]
final readonly class WorkerMessageFailedEventContextExtractor implements ContextExtractorInterface
{
    private const MESSAGE = '[MetricsPower] [ERROR] [MESSAGE: Operation failed] [TARGET_CLASS: {target_class}] [EXCEPTION_CLASS: {exception_class}] [EXCEPTION_MESSAGE: {exception_message}]';

    public function __construct(
        private SerializerInterface $serializer,
    ) {}

    public function extract(WorkerMessageFailedEvent $target): LoggerContext
    {
        $exception = $target->getThrowable();
        $message = $target->getEnvelope()->getMessage();
        $context = [
            'target_class' => ClassHelper::getShortName($target),
            'target_values' => $this->serializer->serialize($target, JsonEncoder::FORMAT),
            'message_class' => ClassHelper::getShortName($message),
            'message_values' => $this->serializer->serialize($message, JsonEncoder::FORMAT),
            'exception_class' => ClassHelper::getShortName($exception),
            'exception_message' => $exception->getMessage(),
            'exception_trace' => $exception->getTrace(),
        ];

        if (($options = MetricalHelper::getFirstOptions($message)) && $options->isSerializable()) {
            $context += [
                'options_class' => ClassHelper::getShortName($options),
                'options_values' => $this->serializer->serialize($options, JsonEncoder::FORMAT),
            ];
        }

        return new LoggerContext(self::MESSAGE, $context);
    }

    public static function getType(): string
    {
        return WorkerMessageFailedEvent::class;
    }
}

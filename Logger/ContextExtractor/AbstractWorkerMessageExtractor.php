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

use FRZB\Component\MetricsPower\Helper\ClassHelper;
use FRZB\Component\MetricsPower\Helper\MetricalHelper;
use FRZB\Component\MetricsPower\Logger\Data\LoggerContext;
use Symfony\Component\Messenger\Event\AbstractWorkerMessageEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

abstract readonly class AbstractWorkerMessageExtractor implements ContextExtractorInterface
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {}

    public function extract(AbstractWorkerMessageEvent $target): LoggerContext
    {
        $message = $target->getEnvelope()->getMessage();
        $context = [
            'target_class' => ClassHelper::getShortName($target),
            'target_values' => $this->serializer->serialize($target, JsonEncoder::FORMAT),
        ];

        if (($options = MetricalHelper::getFirstOptions($message)) && $options->isSerializable()) {
            $context += [
                'message_class' => ClassHelper::getShortName($message),
                'message_values' => $this->serializer->serialize($message, JsonEncoder::FORMAT),
                'options_class' => ClassHelper::getShortName($options),
                'options_values' => $this->serializer->serialize($options, JsonEncoder::FORMAT),
            ];
        }

        return new LoggerContext(static::getMessage(), $context);
    }

    abstract protected static function getMessage(): string;
}

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

use FRZB\Component\MetricsPower\Attribute\OptionsInterface;
use FRZB\Component\MetricsPower\Helper\ClassHelper;
use FRZB\Component\MetricsPower\Logger\Data\Context;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractWorkerMessageExtractor
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {}

    public function extract(mixed $target, ?OptionsInterface $options = null, ?\Throwable $exception = null): Context
    {
        $context = [
            'target_class' => ClassHelper::getShortName($target),
            'message_class' => ClassHelper::getShortName($target->getEnvelope()->getMessage()),
        ];

        if ($options?->isSerializable()) {
            $context += ['message_values' => $this->serializer->serialize($target->getEnvelope()->getMessage(), JsonEncoder::FORMAT)];
        }

        if ($options) {
            $context += [
                'options_class' => ClassHelper::getShortName($options),
            ];
        }

        return new Context($this->getMessage(), $context);
    }

    abstract protected function getMessage(): string;
}

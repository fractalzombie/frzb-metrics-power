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
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[AsService, AsTagged(ContextExtractorInterface::class)]
final readonly class DefaultContextExtractor implements ContextExtractorInterface
{
    private const MESSAGE = '[MetricsPower] [INFO] [MESSAGE: Operation succeed] [TARGET_CLASS: {target_class}]';

    public function __construct(
        private SerializerInterface $serializer,
    ) {}

    public function extract(object $target): LoggerContext
    {
        $context = [
            'target_class' => ClassHelper::getShortName($target),
        ];

        if (($options = MetricalHelper::getFirstOptions($target)) && $options?->isSerializable()) {
            $context += [
                'target_values' => $this->serializer->serialize($target, JsonEncoder::FORMAT),
                'options_class' => ClassHelper::getShortName($options),
                'options_values' => ClassHelper::getProperties($target),
            ];
        }

        return new LoggerContext(self::MESSAGE, $context);
    }

    public static function getType(): string
    {
        return 'Default';
    }
}

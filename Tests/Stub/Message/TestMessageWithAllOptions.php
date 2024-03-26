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

namespace FRZB\Component\MetricsPower\Tests\Stub\Message;

use FRZB\Component\MetricsPower\Attribute\LoggerOptions;
use FRZB\Component\MetricsPower\Attribute\Metrical;
use FRZB\Component\MetricsPower\Attribute\PrometheusOptions;
use FRZB\Component\MetricsPower\Attribute\SentryOptions;
use FRZB\Component\MetricsPower\Tests\Stub\TestConstants;

/** @internal */
#[Metrical(
    new LoggerOptions(),
    new SentryOptions(),
    new PrometheusOptions(
        TestConstants::DEFAULT_RECEIVER_NAME,
        'prometheus-default-options',
        'Total of test value',
        ['name'],
        ['TestMessage']
    ),
)]
class TestMessageWithAllOptions
{
    public function __construct(
        public readonly string $id,
    ) {}

    public static function getShortName(): string
    {
        return (new \ReflectionClass(self::class))->getShortName();
    }
}

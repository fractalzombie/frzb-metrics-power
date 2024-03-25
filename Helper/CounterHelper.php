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

namespace FRZB\Component\MetricsPower\Helper;

use FRZB\Component\MetricsPower\Attribute\PrometheusOptions;
use FRZB\Component\MetricsPower\Traits\WithEmptyPrivateConstructor;

final class CounterHelper
{
    use WithEmptyPrivateConstructor;

    private const REPLACE_FROM = ['-', '.'];
    private const REPLACE_TO = ['_', '_'];

    public static function makeName(PrometheusOptions $options, ?string $prefix = null, ?string $postfix = null): string
    {
        return match (true) {
            null !== $prefix && null !== $postfix => str_replace(self::REPLACE_FROM, self::REPLACE_TO, sprintf('%s_%s_%s_%s', $prefix, $options->topic, $options->name, $postfix)),
            null !== $prefix => str_replace(self::REPLACE_FROM, self::REPLACE_TO, sprintf('%s_%s_%s', $prefix, $options->topic, $options->name)),
            null !== $postfix => str_replace(self::REPLACE_FROM, self::REPLACE_TO, sprintf('%s_%s_%s', $options->topic, $options->name, $postfix)),
            default => str_replace(self::REPLACE_FROM, self::REPLACE_TO, sprintf('%s_%s', $options->topic, $options->name)),
        };
    }
}

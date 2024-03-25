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

use Fp\Collections\ArrayList;
use FRZB\Component\MetricsPower\Attribute\Metrical;
use FRZB\Component\MetricsPower\Attribute\OptionsInterface as Option;
use FRZB\Component\MetricsPower\Attribute\PrometheusOptions;
use FRZB\Component\MetricsPower\Traits\WithEmptyPrivateConstructor;
use JetBrains\PhpStorm\Immutable;

/** @internal */
#[Immutable]
final class MetricalHelper
{
    use WithEmptyPrivateConstructor;

    public static function isMetrical(object|string $target): bool
    {
        return AttributeHelper::hasAttribute($target, Metrical::class);
    }

    public static function getMetrical(object|string $target): array
    {
        return AttributeHelper::getAttributes($target, Metrical::class);
    }

    /** @return array<Option> */
    public static function getOptions(object|string $target): array
    {
        return ArrayList::collect(self::getMetrical($target))
            ->map(static fn (Metrical $metrical) => $metrical->options)
            ->flatten()
            ->toList()
        ;
    }

    public static function getCounterName(PrometheusOptions $options): string
    {
        return str_replace('-', '_', "{$options->topic}-{$options->name}");
    }
}

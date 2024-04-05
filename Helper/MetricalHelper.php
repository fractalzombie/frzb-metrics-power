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
use FRZB\Component\MetricsPower\Attribute\LoggerOptions;
use FRZB\Component\MetricsPower\Attribute\Metrical;
use FRZB\Component\MetricsPower\Attribute\OptionsInterface;
use FRZB\Component\MetricsPower\Attribute\PrometheusOptions;
use FRZB\Component\MetricsPower\Traits\WithPrivateEmptyConstructor;
use JetBrains\PhpStorm\Immutable;

/** @internal */
#[Immutable]
final class MetricalHelper
{
    use WithPrivateEmptyConstructor;

    public static function isMetrical(object|string $target): bool
    {
        return AttributeHelper::hasAttribute($target, Metrical::class);
    }

    public static function getMetrical(object|string $target): ?Metrical
    {
        return ArrayList::collect(AttributeHelper::getAttributes($target, Metrical::class))->firstElement()->get();
    }

    /** @return array<OptionsInterface> */
    public static function getOptions(object|string $target): array
    {
        return ArrayList::collect(self::getMetrical($target)?->options ?? [])
            ->toList();
    }

    public static function getFirstOptions(object|string $target): ?OptionsInterface
    {
        return ArrayList::collect(self::getOptions($target))
            ->firstElement()
            ->getOrElse(new LoggerOptions());
    }

    public static function getCounterName(PrometheusOptions $options): string
    {
        return StringHelper::toSnakeCase(
            str_replace('-', '_', "{$options->topic}_{$options->name}")
        );
    }
}

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

use FRZB\Component\MetricsPower\Traits\WithPrivateEmptyConstructor;
use JetBrains\PhpStorm\Immutable;

/** @internal */
#[Immutable]
final class StringHelper
{
    use WithPrivateEmptyConstructor;

    public static function toSnakeCase(string $value): string
    {
        return strtolower(preg_replace('/[A-Z]/', '_\\0', lcfirst($value)));
    }

    public static function toKebabCase(string $value): string
    {
        return strtolower(preg_replace('/[A-Z]/', '-\\0', lcfirst($value)));
    }

    public static function toPascalCase(string $value): string
    {
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $value)));
    }

    public static function toCamelCase(string $value): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $value))));
    }

    public static function contains(string $value, string $subValue): bool
    {
        return str_contains($value, $subValue);
    }

    public static function makePrefix(string $prefix, ?string $value = null, string $delimiter = '-'): string
    {
        return $value
            ? self::normalize($prefix).$delimiter.$value
            : self::normalize($prefix);
    }

    public static function normalize(string $value): string
    {
        return strtolower(preg_replace('/[^a-zA-Z\\d_-]/', '-', $value));
    }

    public static function removeBrackets(string $value, array $brackets = ['[', ']']): string
    {
        return str_replace($brackets, '', $value);
    }
}

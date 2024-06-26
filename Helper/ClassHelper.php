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
final class ClassHelper
{
    use WithPrivateEmptyConstructor;

    final public const DEFAULT_SHORT_NAME = 'InvalidClassName';

    public static function getShortName(object|string $target): string
    {
        return self::getReflectionClass($target)?->getShortName() ?? self::DEFAULT_SHORT_NAME;
    }

    public static function getProperties(object $target): array
    {
        return get_object_vars($target);
    }

    /**
     * @template T
     *
     * @param class-string<T>|T $target
     *
     * @return null|\ReflectionClass<T>
     */
    public static function getReflectionClass(object|string $target): ?\ReflectionClass
    {
        try {
            return $target instanceof \ReflectionClass ? $target : new \ReflectionClass($target);
        } catch (\ReflectionException) {
            return null;
        }
    }

    /**
     * @template T
     *
     * @param class-string<T>|T $target
     *
     * @return null|\ReflectionClass<T>
     */
    public static function getParentReflectionClass(object|string $target): ?\ReflectionClass
    {
        return self::getReflectionClass($target)?->getParentClass() ?: null;
    }

    /**
     * @template T
     *
     * @param class-string<T> $attributeClass
     *
     * @return \Iterator<\ReflectionAttribute<T>>
     */
    public static function getReflectionAttributes(object|string $target, string $attributeClass): iterable
    {
        return self::getReflectionClass($target)?->getAttributes($attributeClass, \ReflectionAttribute::IS_INSTANCEOF) ?? [];
    }
}

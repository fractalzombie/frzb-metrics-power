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

namespace FRZB\Component\MetricsPower\Traits;

use Fp\Collections\ArrayList;

/**
 * @mixin \BackedEnum
 *
 * @internal
 */
trait WithEnumValues
{
    public static function values(): array
    {
        return ArrayList::collect(self::cases())
            ->map(fn (self $st) => $st->value)
            ->toList();
    }
}

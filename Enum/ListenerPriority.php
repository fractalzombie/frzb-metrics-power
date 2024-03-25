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

namespace FRZB\Component\MetricsPower\Enum;

enum ListenerPriority: int
{
    case Highest = 2048;
    case High = 256;
    case Normal = 0;
    case Low = -256;
    case Lowest = -2048;
    public const HIGHEST = 2048;
    public const HIGH = 256;
    public const NORMAL = 0;
    public const LOW = -256;
    public const LOWEST = -2048;
}

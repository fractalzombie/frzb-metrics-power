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

use FRZB\Component\MetricsPower\Traits\WithEnumValues;

enum StorageType: string
{
    use WithEnumValues;

    case Apc = 'apc';
    case ApcNg = 'apc_ng';
    case Redis = 'redis';
    case RedisNg = 'redis_ng';
    case InMemory = 'in_memory';
    public const APC = 'apc';
    public const APC_NG = 'apc_ng';
    public const REDIS = 'redis';
    public const REDIS_NG = 'redis_ng';
    public const IN_MEMORY = 'in_memory';
}

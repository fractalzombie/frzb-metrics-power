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

namespace FRZB\Component\MetricsPower\Factory\Exception;

use FRZB\Component\MetricsPower\Exception\MetricsPowerException;

final class NoRedisConfigurationProvidedException extends StorageAdapterFactoryException
{
    private const MESSAGE_REDIS_CONFIGURATION_PROVIDED = 'No redis configuration provided';

    public static function create(?\Throwable $previous = null): self
    {
        return new self(self::MESSAGE_REDIS_CONFIGURATION_PROVIDED, previous: $previous);
    }
}

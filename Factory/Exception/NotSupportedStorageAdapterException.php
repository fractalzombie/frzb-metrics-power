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

final class NotSupportedStorageAdapterException extends StorageAdapterFactoryException
{
    private const MESSAGE_NOT_SUPPORTED_STORAGE = 'Storage type "%s" is not supported';

    public static function fromStorageType(string $storageType, ?\Throwable $previous = null): self
    {
        $message = sprintf(self::MESSAGE_NOT_SUPPORTED_STORAGE, $storageType);

        return new self($message, previous: $previous);
    }
}

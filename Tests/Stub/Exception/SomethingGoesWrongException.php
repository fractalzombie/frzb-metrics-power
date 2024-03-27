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

namespace FRZB\Component\MetricsPower\Tests\Stub\Exception;

use FRZB\Component\MetricsPower\Exception\MetricsPowerException;

/** @internal */
final class SomethingGoesWrongException extends MetricsPowerException
{
    private const MESSAGE_SOMETHING_GOES_WRONG = 'Something goes wrong';

    public static function wrong(?\Throwable $previous = null): self
    {
        return new self(self::MESSAGE_SOMETHING_GOES_WRONG, previous: $previous);
    }
}
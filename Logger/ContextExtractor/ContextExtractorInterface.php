<?php

/** @noinspection PhpDocSignatureInspection */

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

namespace FRZB\Component\MetricsPower\Logger\ContextExtractor;

use FRZB\Component\MetricsPower\Attribute\OptionsInterface;
use FRZB\Component\MetricsPower\Logger\Data\Context;

/**
 * @template TTarget of mixed
 * @template TOptions of OptionsInterface
 */
interface ContextExtractorInterface
{
    /**
     * @param TTarget $target
     * @param TOptions $options
     * @param ?\Throwable $exception
     */
    public function extract(mixed $target, ?OptionsInterface $options = null, ?\Throwable $exception = null): Context;

    public static function getType(): string;
}

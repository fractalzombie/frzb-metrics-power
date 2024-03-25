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

namespace FRZB\Component\MetricsPower\Attribute;

use FRZB\Component\MetricsPower\Helper\MetricalHelper;

#[\Attribute(\Attribute::TARGET_CLASS)]
final class PrometheusOptions implements OptionsInterface
{
    public readonly string $counterName;

    public function __construct(
        public readonly string $topic,
        public readonly string $name,
        public readonly string $help,
        public readonly array $labels,
        public readonly array $values,
    ) {
        $this->counterName = MetricalHelper::getCounterName($this);
    }
}

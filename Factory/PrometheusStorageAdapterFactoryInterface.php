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

namespace FRZB\Component\MetricsPower\Factory;

use FRZB\Component\DependencyInjection\Attribute\AsAlias;
use FRZB\Component\MetricsPower\Factory\Exception\StorageAdapterFactoryException;
use Prometheus\Storage\Adapter;

#[AsAlias(PrometheusStorageAdapterFactory::class)]
interface PrometheusStorageAdapterFactoryInterface
{
    /** @throws StorageAdapterFactoryException */
    public static function createStorageAdapter(array $configuration): Adapter;
}

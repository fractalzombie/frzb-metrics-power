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

namespace FRZB\Component\MetricsPower\Tests\Feature\Factory;

use FRZB\Component\MetricsPower\Enum\StorageType;
use FRZB\Component\MetricsPower\Factory\Exception\NotSupportedStorageAdapterException;
use FRZB\Component\MetricsPower\Factory\PrometheusStorageAdapterFactoryInterface;
use Prometheus\Storage\APC;
use Prometheus\Storage\APCng;
use Prometheus\Storage\InMemory;
use Prometheus\Storage\Redis;
use Prometheus\Storage\RedisNg;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

uses(KernelTestCase::class);

beforeEach(function (): void {
    $this->ensureKernelShutdown();
    $this->bootKernel();
});

test('It can create needed storage adapter', function (StorageType $storage): void {
    $factory = $this->getContainer()->get(PrometheusStorageAdapterFactoryInterface::class);

    $storageAdapter = $factory->createStorageAdapter(['storage' => $storage->value, 'redis' => []]);

    expect($storageAdapter)->toBeInstanceOf(
        match ($storage) {
            StorageType::Redis => Redis::class,
            StorageType::RedisNg => RedisNg::class,
            StorageType::InMemory => InMemory::class,
            default => throw new \InvalidArgumentException('Unexpected match value'),
        }
    );
})->with([
    StorageType::Redis,
    StorageType::RedisNg,
    StorageType::InMemory,
]);

test('It can create apcu, apcu-ng storage adapter', function (StorageType $storage): void {
    $factory = $this->getContainer()->get(PrometheusStorageAdapterFactoryInterface::class);

    $storageAdapter = $factory->createStorageAdapter(['storage' => $storage->value, 'redis' => []]);

    expect($storageAdapter)->toBeInstanceOf(
        match ($storage) {
            StorageType::Apc => APC::class,
            StorageType::ApcNg => APCng::class,
            default => throw new \InvalidArgumentException('Unexpected match value'),
        }
    );
})->with([
    StorageType::Apc,
    StorageType::ApcNg,
])->skip(!\extension_loaded('apcu') || !apcu_enabled());

test('It can not create unknown storage adapter', function (): void {
    $factory = $this->getContainer()->get(PrometheusStorageAdapterFactoryInterface::class);

    $factory->createStorageAdapter(['storage' => 'unknown-storage']);
})->throws(NotSupportedStorageAdapterException::class);

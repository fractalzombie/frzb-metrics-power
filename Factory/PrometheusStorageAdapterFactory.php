<?php

declare(strict_types=1);

/*
 * UnBlocker service for routers.
 *
 * (c) Mykhailo Shtanko <fractalzombie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FRZB\Component\MetricsPower\Factory;

use FRZB\Component\MetricsPower\DependencyInjection\Configuration;
use FRZB\Component\MetricsPower\Enum\StorageType;
use FRZB\Component\MetricsPower\Factory\Exception\NoRedisConfigurationProvidedException;
use FRZB\Component\MetricsPower\Factory\Exception\NotSupportedStorageAdapterException;
use Prometheus\Storage\Adapter;
use Prometheus\Storage\APC;
use Prometheus\Storage\APCng;
use Prometheus\Storage\InMemory;
use Prometheus\Storage\Redis;
use Prometheus\Storage\RedisNg;

final class PrometheusStorageAdapterFactory implements PrometheusStorageAdapterFactoryInterface
{
    public static function createStorageAdapter(array $configuration): Adapter
    {
        return match (self::getStorageType($configuration)) {
            StorageType::Apc => new APC(),
            StorageType::ApcNg => new APCng(),
            StorageType::Redis => new Redis(self::getRedisConfiguration($configuration)),
            StorageType::RedisNg => new RedisNg(self::getRedisConfiguration($configuration)),
            StorageType::InMemory => new InMemory(),
        };
    }

    /** @throws NotSupportedStorageAdapterException */
    private static function getStorageType(array $configuration): StorageType
    {
        $storage = $configuration['storage'] ?? null;

        return StorageType::tryFrom($storage) ?? throw NotSupportedStorageAdapterException::fromStorageType($storage);
    }

    /** @throws NoRedisConfigurationProvidedException */
    private static function getRedisConfiguration(array $configuration): array
    {
        return $configuration[Configuration::PROMETHEUS_REDIS] ?? throw NoRedisConfigurationProvidedException::create();
    }
}

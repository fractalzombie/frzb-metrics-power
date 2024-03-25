<?php

declare(strict_types=1);


namespace FRZB\Component\MetricsPower\Factory;


use FRZB\Component\MetricsPower\Factory\Exception\StorageAdapterFactoryException;
use Prometheus\Storage\Adapter;

interface PrometheusStorageAdapterFactoryInterface
{
    /** @throws StorageAdapterFactoryException */
    public static function createStorageAdapter(array $configuration): Adapter;
}
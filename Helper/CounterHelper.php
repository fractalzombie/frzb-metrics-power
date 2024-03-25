<?php

declare(strict_types=1);


namespace FRZB\Component\MetricsPower\Helper;


use FRZB\Component\MetricsPower\Attribute\PrometheusOptions;
use FRZB\Component\MetricsPower\Traits\WithEmptyPrivateConstructor;

final class CounterHelper
{
    use WithEmptyPrivateConstructor;

    public static function makeName(PrometheusOptions $options): string
    {
        return str_replace(['-', '.'], ['_', '_'], sprintf('%s_%s', $options->topic, $options->name));
    }
}
<?php

declare(strict_types=1);


namespace FRZB\Component\MetricsPower\Logger\ContextProvider;


use FRZB\Component\MetricsPower\Logger\Data\Context;

interface ContextProviderInterface
{
    public function provider(object $target): Context;
}
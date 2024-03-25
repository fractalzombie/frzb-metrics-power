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

namespace FRZB\Component\MetricsPower;

use FRZB\Component\MetricsPower\DependencyInjection\Compiler\CollectorRegistryPass;
use FRZB\Component\MetricsPower\DependencyInjection\Compiler\SentryPass;
use FRZB\Component\MetricsPower\DependencyInjection\Compiler\StorageAdapterPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class MetricsPowerBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->registerExtension(new MetricsPowerExtension());
        $container->addCompilerPass(new SentryPass());
        $container->addCompilerPass(new StorageAdapterPass());
        $container->addCompilerPass(new CollectorRegistryPass());
    }
}

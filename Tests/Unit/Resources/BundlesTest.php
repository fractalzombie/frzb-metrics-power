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

namespace FRZB\Component\MetricsPower\Tests\Unit\Resources;

use FRZB\Component\DependencyInjection\DependencyInjectionBundle;
use FRZB\Component\MetricsPower\MetricsPowerBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;

it('Has all dependencies in bundles.php', function (): void {
    $bundles = require __DIR__.'/../../../Resources/bundles.php';
    $expectedBundles = [
        FrameworkBundle::class => ['all' => true],
        DependencyInjectionBundle::class => ['all' => true],
        MetricsPowerBundle::class => ['all' => true],
    ];

    expect($expectedBundles)->toBe($bundles);
});

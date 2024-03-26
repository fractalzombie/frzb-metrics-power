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

namespace FRZB\Component\MetricsPower\Tests\Feature\Action;

use FRZB\Component\MetricsPower\Action\MetricsAction;
use FRZB\Component\MetricsPower\Exception\MetricsRenderException;
use Prometheus\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

uses(KernelTestCase::class);

beforeEach(function (): void {
    $this->ensureKernelShutdown();
    $this->bootKernel();
});

test('It can generate correct prometheus metrics', function (): void {
    $response = $this->getContainer()->get(MetricsAction::class)();

    expect($response->getContent())
        ->toContain('# HELP php_info Information about the PHP environment')
        ->toContain('# TYPE php_info gauge')
        ->and((bool) preg_match('/php_info{version="[\d+].+"} [\d+]+/', $response->getContent()))->toBeTrue();
});

test('It can throws when something goes wrong', function (): void {
    $registry = \Mockery::mock(RegistryInterface::class);
    $this->getContainer()->set(RegistryInterface::class, $registry);

    $registry
        ->expects('getMetricFamilySamples')
        ->andThrow(new \Exception('Something goes wrong'));

    $this->getContainer()->get(MetricsAction::class)();
})->expectException(MetricsRenderException::class);

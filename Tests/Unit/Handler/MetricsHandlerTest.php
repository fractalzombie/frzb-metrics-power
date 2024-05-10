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

namespace FRZB\Component\MetricsPower\Tests\Unit\Handler;

use FRZB\Component\MetricsPower\Attribute\OptionsInterface;
use FRZB\Component\MetricsPower\Attribute\PrometheusOptions;
use FRZB\Component\MetricsPower\Handler\MetricsHandler;
use FRZB\Component\MetricsPower\OptionsResolver\OptionsResolverLocatorInterface;
use FRZB\Component\MetricsPower\OptionsResolver\Resolver\OptionsResolverInterface;
use FRZB\Component\MetricsPower\Tests\Stub\Exception\SomethingGoesWrongException;
use FRZB\Component\MetricsPower\Tests\Stub\TestConstants;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;

test('it can handle and log event with message', function (): void {
    $locator = \Mockery::mock(OptionsResolverLocatorInterface::class);
    $resolver = \Mockery::mock(OptionsResolverInterface::class);
    $event = new SendMessageToTransportsEvent(createTestEnvelope(), [TestConstants::DEFAULT_RECEIVER_NAME]);
    $handler = new MetricsHandler($locator);

    $locator
        ->expects('get')
        ->once()
        ->andReturn($resolver);

    $resolver
        ->expects('resolve')
        ->once()
        ->andReturnUsing(function (object $event, OptionsInterface $options): void {
            expect()
                ->and($options)->toBeInstanceOf(PrometheusOptions::class)
                ->and($event)->toBeInstanceOf(SendMessageToTransportsEvent::class);
        });

    $handler->handle($event);
});

test('it can handle and log when caught', function (): void {
    $locator = \Mockery::mock(OptionsResolverLocatorInterface::class);
    $resolver = \Mockery::mock(OptionsResolverInterface::class);
    $event = new SendMessageToTransportsEvent(createTestEnvelope(), [TestConstants::DEFAULT_RECEIVER_NAME]);
    $handler = new MetricsHandler($locator);

    $locator
        ->expects('get')
        ->once()
        ->andReturn($resolver);

    $resolver
        ->expects('resolve')
        ->once()
        ->andThrow(SomethingGoesWrongException::wrong());

    $handler->handle($event);
})->throws(SomethingGoesWrongException::class);

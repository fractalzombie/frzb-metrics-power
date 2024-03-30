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

namespace FRZB\Component\MetricsPower\Tests\Unit\OptionsResolver;

use FRZB\Component\MetricsPower\Attribute\SentryOptions;
use FRZB\Component\MetricsPower\OptionsResolver\Resolver\SentryOptionsResolver;
use FRZB\Component\MetricsPower\Tests\Stub\Exception\SomethingGoesWrongException;
use FRZB\Component\MetricsPower\Tests\Stub\TestConstants;
use Sentry\ClientInterface;
use Sentry\State\HubInterface;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;

test('It can capture exception when not set for retry', function (): void {
    $sentryHub = \Mockery::mock(HubInterface::class);
    $sentryOptionsResolver = new SentryOptionsResolver($sentryHub);
    $envelope = createTestEnvelope();
    $event = new WorkerMessageFailedEvent($envelope, TestConstants::DEFAULT_RECEIVER_NAME, SomethingGoesWrongException::wrong());
    $options = new SentryOptions();

    $sentryHub
        ->expects('captureException')
        ->once();

    $sentryOptionsResolver->resolve($event, $options);
});

test('It can capture exception when set for retry', function (): void {
    $sentryHub = \Mockery::mock(HubInterface::class);
    $sentryOptionsResolver = new SentryOptionsResolver($sentryHub);
    $envelope = createTestEnvelope();
    $event = new WorkerMessageFailedEvent($envelope, TestConstants::DEFAULT_RECEIVER_NAME, SomethingGoesWrongException::wrong());
    $options = new SentryOptions();

    $event->setForRetry();

    $sentryHub
        ->expects('captureException')
        ->never();

    $sentryOptionsResolver->resolve($event, $options);
});

test('It can flush when handled', function (): void {
    $hubClient = \Mockery::mock(ClientInterface::class);
    $sentryHub = \Mockery::mock(HubInterface::class);
    $sentryOptionsResolver = new SentryOptionsResolver($sentryHub);
    $envelope = createTestEnvelope();
    $event = new WorkerMessageHandledEvent($envelope, TestConstants::DEFAULT_RECEIVER_NAME);
    $options = new SentryOptions();

    $hubClient
        ->expects('flush')
        ->once();

    $sentryHub->expects('getClient')
        ->once()
        ->andReturn($hubClient);

    $sentryOptionsResolver->resolve($event, $options);
});

test('It has correct type', function (): void {
    expect(SentryOptionsResolver::getType())->toBe(SentryOptions::class);
});

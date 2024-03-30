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

use FRZB\Component\MetricsPower\Attribute\LoggerOptions;
use FRZB\Component\MetricsPower\Logger\MetricsPowerLoggerInterface;
use FRZB\Component\MetricsPower\OptionsResolver\Resolver\LoggerOptionsResolver;
use FRZB\Component\MetricsPower\Tests\Stub\Exception\SomethingGoesWrongException;
use FRZB\Component\MetricsPower\Tests\Stub\Message\TestMessageWithAllOptions;
use FRZB\Component\MetricsPower\Tests\Stub\TestConstants;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;

test('It can log error when message failed', function (): void {
    $logger = \Mockery::mock(MetricsPowerLoggerInterface::class);
    $loggerOptionsResolver = new LoggerOptionsResolver($logger);
    $envelope = createTestEnvelope(new TestMessageWithAllOptions(TestConstants::DEFAULT_ID));
    $event = new WorkerMessageFailedEvent($envelope, TestConstants::DEFAULT_RECEIVER_NAME, SomethingGoesWrongException::wrong());
    $exception = SomethingGoesWrongException::wrong();
    $options = new LoggerOptions();

    $logger
        ->expects('error')
        ->once();

    $loggerOptionsResolver->resolve($event, $options);
});

test('It can log info when message handled', function (): void {
    $logger = \Mockery::mock(MetricsPowerLoggerInterface::class);
    $loggerOptionsResolver = new LoggerOptionsResolver($logger);
    $envelope = createTestEnvelope(new TestMessageWithAllOptions(TestConstants::DEFAULT_ID));
    $event = new WorkerMessageHandledEvent($envelope, TestConstants::DEFAULT_RECEIVER_NAME);
    $options = new LoggerOptions();

    $logger
        ->expects('info')
        ->once();

    $loggerOptionsResolver->resolve($event, $options);
});

test('It has correct type', function (): void {
    expect(LoggerOptionsResolver::getType())->toBe(LoggerOptions::class);
});

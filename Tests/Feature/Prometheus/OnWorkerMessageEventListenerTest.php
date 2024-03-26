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

namespace FRZB\Component\MetricsPower\Tests\Feature\Kernel\Sentry;

use FRZB\Component\MetricsPower\EventListener\Prometheus\OnWorkerMessageEventListener;
use FRZB\Component\MetricsPower\Handler\MetricsHandlerInterface;
use FRZB\Component\MetricsPower\Tests\Stub\Exception\SomethingGoesWrongException;
use FRZB\Component\MetricsPower\Tests\Stub\TestConstants;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;
use Symfony\Component\Messenger\Event\WorkerMessageReceivedEvent;
use Symfony\Component\Messenger\Event\WorkerMessageRetriedEvent;

uses(KernelTestCase::class);

beforeEach(function (): void {
    $this->ensureKernelShutdown();
    $this->bootKernel();
});

test('It handles symfony messenger events', function (mixed $event): void {
    $metricsHandler = \Mockery::mock(MetricsHandlerInterface::class);

    $metricsHandler
        ->expects('handle')
        ->once();

    $this->getContainer()->set(MetricsHandlerInterface::class, $metricsHandler);

    $this->getContainer()->get(OnWorkerMessageEventListener::class)($event);
})->with(function () {
    yield WorkerMessageHandledEvent::class => [
        'event' => new WorkerMessageHandledEvent(createTestEnvelope(), TestConstants::DEFAULT_RECEIVER_NAME),
    ];

    yield WorkerMessageReceivedEvent::class => [
        'event' => new WorkerMessageReceivedEvent(createTestEnvelope(), TestConstants::DEFAULT_RECEIVER_NAME),
    ];

    yield WorkerMessageRetriedEvent::class => [
        'event' => new WorkerMessageRetriedEvent(createTestEnvelope(), TestConstants::DEFAULT_RECEIVER_NAME),
    ];

    yield WorkerMessageFailedEvent::class => [
        'event' => new WorkerMessageFailedEvent(createTestEnvelope(), TestConstants::DEFAULT_RECEIVER_NAME, SomethingGoesWrongException::wrong()),
    ];

    yield SendMessageToTransportsEvent::class => [
        'event' => new SendMessageToTransportsEvent(createTestEnvelope(), [TestConstants::DEFAULT_RECEIVER_NAME]),
    ];
});

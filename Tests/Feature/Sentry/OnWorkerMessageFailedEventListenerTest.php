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

use FRZB\Component\MetricsPower\EventListener\Sentry\OnWorkerMessageFailedEventListener;
use FRZB\Component\MetricsPower\Handler\MetricsHandlerInterface;
use FRZB\Component\MetricsPower\Tests\Stub\Exception\SomethingGoesWrongException;
use FRZB\Component\MetricsPower\Tests\Stub\TestConstants;
use Sentry\State\HubInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;

uses(KernelTestCase::class);

beforeEach(function (): void {
    $this->ensureKernelShutdown();
    $this->bootKernel();
});

test('It handles symfony messenger failed events with no retry', function (): void {
    $event = new WorkerMessageFailedEvent(createTestEnvelope(), TestConstants::DEFAULT_RECEIVER_NAME, SomethingGoesWrongException::wrong());
    $sentryHub = \Mockery::mock(HubInterface::class);

    $sentryHub->expects('captureException')->never();

    $this->getContainer()->set(MetricsHandlerInterface::class, $sentryHub);

    $this->getContainer()->get(OnWorkerMessageFailedEventListener::class)($event);
});

test('It handles symfony messenger failed events with retry', function (): void {
    $event = new WorkerMessageFailedEvent(createTestEnvelope(), TestConstants::DEFAULT_RECEIVER_NAME, SomethingGoesWrongException::wrong());
    $sentryHub = \Mockery::mock(HubInterface::class);

    $event->setForRetry();
    $sentryHub->expects('captureException')->never();

    $this->getContainer()->set(MetricsHandlerInterface::class, $sentryHub);

    $this->getContainer()->get(OnWorkerMessageFailedEventListener::class)($event);
});

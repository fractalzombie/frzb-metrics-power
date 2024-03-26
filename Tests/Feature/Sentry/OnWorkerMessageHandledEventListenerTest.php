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
use FRZB\Component\MetricsPower\EventListener\Sentry\OnWorkerMessageHandledEventListener;
use FRZB\Component\MetricsPower\Handler\MetricsHandlerInterface;
use FRZB\Component\MetricsPower\Tests\Stub\Exception\SomethingGoesWrongException;
use FRZB\Component\MetricsPower\Tests\Stub\TestConstants;
use Sentry\ClientInterface;
use Sentry\State\HubInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;

uses(KernelTestCase::class);

beforeEach(function (): void {
    $this->ensureKernelShutdown();
    $this->bootKernel();
});

test('It handles symfony messenger handled events', function (): void {
    $event = new WorkerMessageHandledEvent(createTestEnvelope(), TestConstants::DEFAULT_RECEIVER_NAME);
    $sentryClient = \Mockery::mock(ClientInterface::class);
    $sentryHub = \Mockery::mock(HubInterface::class);

    $sentryClient->expects('flush')->once();
    $sentryHub->expects('getClient')->andReturn($sentryClient)->once();

    $this->getContainer()->set(HubInterface::class, $sentryHub);

    $this->getContainer()->get(OnWorkerMessageHandledEventListener::class)($event);
});

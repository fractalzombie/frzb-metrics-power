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
use FRZB\Component\MetricsPower\EventListener\Sentry\OnWorkerMessageHandledEventListener;
use FRZB\Component\MetricsPower\Helper\EnvelopeHelper;
use FRZB\Component\MetricsPower\Tests\Stub\Exception\SomethingGoesWrongException;
use FRZB\Component\MetricsPower\Tests\Stub\Message\TestMessage;
use FRZB\Component\MetricsPower\Tests\Stub\TestConstants;
use Sentry\ClientInterface;
use Sentry\State\HubInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;

uses(KernelTestCase::class);

beforeEach(function (): void {
    $this->ensureKernelShutdown();
    $this->bootKernel();
});

test(sprintf('Sentry flushes on %s message handle', TestMessage::getShortName()), function (): void {
    $hubClient = Mockery::mock(ClientInterface::class);
    $hubClient
        ->expects('flush')
        ->once()
    ;

    $sentryHub = Mockery::mock(HubInterface::class);
    $sentryHub->expects('getClient')
        ->once()
        ->andReturn($hubClient)
    ;

    $this->getContainer()->set(HubInterface::class, $sentryHub);
    $exception = SomethingGoesWrongException::wrong();
    $message = EnvelopeHelper::wrap(new TestMessage(TestConstants::DEFAULT_ID));
    $event = new WorkerMessageHandledEvent($message, TestConstants::DEFAULT_RECEIVER_NAME);

    $this->getContainer()->get(OnWorkerMessageHandledEventListener::class)($event);
});

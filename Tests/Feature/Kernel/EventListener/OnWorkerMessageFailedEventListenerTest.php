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
use FRZB\Component\MetricsPower\EventListener\Sentry\OnWorkerMessageFailedEventListener;
use FRZB\Component\MetricsPower\Helper\EnvelopeHelper;
use FRZB\Component\MetricsPower\Tests\Stub\Exception\SomethingGoesWrongException;
use FRZB\Component\MetricsPower\Tests\Stub\Message\TestMessage;
use FRZB\Component\MetricsPower\Tests\Stub\TestConstants;
use Sentry\State\HubInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;

uses(KernelTestCase::class);

beforeEach(function (): void {
    $this->ensureKernelShutdown();
    $this->bootKernel();
});

test(sprintf('Sentry captures exception when %s message failed', TestMessage::getShortName()), function (WorkerMessageFailedEvent $event): void {
    $sentryHub = Mockery::mock(HubInterface::class);
    $this->getContainer()->set(HubInterface::class, $sentryHub);

    if ($event->willRetry()) {
        $sentryHub->expects('captureException')->never();
    } else {
        $sentryHub->expects('captureException')->once()
            ->andReturnUsing(function (SomethingGoesWrongException $e): void {
                expect($e->getMessage())->toBe('Something goes wrong');
            })
        ;
    }

    $this->getContainer()->get(OnWorkerMessageFailedEventListener::class)($event);
})->with(function () {
    $message = EnvelopeHelper::wrap(new TestMessage(TestConstants::DEFAULT_ID));
    $exception = SomethingGoesWrongException::wrong();
    $event = (new WorkerMessageFailedEvent($message, TestConstants::DEFAULT_RECEIVER_NAME, $exception));
    $event->setForRetry();

    yield 'with retry' => [
        'event' => $event,
    ];

    yield 'without retry' => [
        'event' => (new WorkerMessageFailedEvent($message, TestConstants::DEFAULT_RECEIVER_NAME, $exception)),
    ];
});

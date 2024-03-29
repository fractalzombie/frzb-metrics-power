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

namespace FRZB\Component\MetricsPower\Tests\Feature\Logger;

use FRZB\Component\MetricsPower\Helper\ClassHelper;
use FRZB\Component\MetricsPower\Helper\MetricalHelper;
use FRZB\Component\MetricsPower\Logger\ContextExtractor\ContextExtractorInterface;
use FRZB\Component\MetricsPower\Logger\ContextExtractorLocatorInterface;
use FRZB\Component\MetricsPower\Logger\Data\LoggerContext;
use FRZB\Component\MetricsPower\Logger\MetricsPowerLogger;
use FRZB\Component\MetricsPower\Tests\Stub\Exception\SomethingGoesWrongException;
use FRZB\Component\MetricsPower\Tests\Stub\TestConstants;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;

uses(KernelTestCase::class);

beforeEach(function (): void {
    $this->ensureKernelShutdown();
    $this->bootKernel();
});

test('It can map info log', function (): void {
    $decoratedLogger = \Mockery::mock(LoggerInterface::class);
    $contextExtractor = \Mockery::mock(ContextExtractorInterface::class);
    $contextExtractorLocator = \Mockery::mock(ContextExtractorLocatorInterface::class);
    $metricsPowerLogger = new MetricsPowerLogger($contextExtractorLocator, $decoratedLogger);
    $message = createTestMessage();
    $envelope = createTestEnvelope($message);
    $options = MetricalHelper::getFirstOptions($message);
    $event = new WorkerMessageHandledEvent($envelope, TestConstants::DEFAULT_RECEIVER_NAME);
    $context = new LoggerContext(
        '[MetricsPower] [ERROR] [OPTIONS_CLASS: {option_class}] Metrics registration failed for [MESSAGE_CLASS: {message_class}] [REASON: {reason_message}] [OPTIONS_VALUES: {option_values}]',
        [
            'option_class' => ClassHelper::getShortName($options),
            'message_class' => ClassHelper::getShortName($message),
        ]
    );

    $contextExtractor
        ->expects('extract')
        ->once()
        ->andReturn($context);

    $contextExtractorLocator
        ->expects('get')
        ->once()
        ->andReturn($contextExtractor);

    $decoratedLogger->expects('info')
        ->once()
        ->andReturnUsing(function (string $logMessage, array $logContext) use ($context): void {
            expect()
                ->and($logMessage)->toBe($context->message)
                ->and($logContext)->toBe($context->context);
        });

    $metricsPowerLogger->info($event, $options);
});

test('It can map error log', function (): void {
    $decoratedLogger = \Mockery::mock(LoggerInterface::class);
    $contextExtractor = \Mockery::mock(ContextExtractorInterface::class);
    $contextExtractorLocator = \Mockery::mock(ContextExtractorLocatorInterface::class);
    $metricsPowerLogger = new MetricsPowerLogger($contextExtractorLocator, $decoratedLogger);
    $message = createTestMessage();
    $envelope = createTestEnvelope($message);
    $exception = SomethingGoesWrongException::wrong();
    $options = MetricalHelper::getFirstOptions($message);
    $event = new WorkerMessageHandledEvent($envelope, TestConstants::DEFAULT_RECEIVER_NAME);
    $context = new LoggerContext(
        '[MetricsPower] [ERROR] [OPTIONS_CLASS: {option_class}] Metrics registration failed for [MESSAGE_CLASS: {message_class}] [REASON: {reason_message}] [OPTIONS_VALUES: {option_values}]',
        [
            'option_class' => ClassHelper::getShortName($options),
            'option_values' => ClassHelper::getProperties($options),
            'message_class' => ClassHelper::getShortName($event->getEnvelope()->getMessage()),
            'reason_message' => $exception->getMessage(),
            'reason_trace' => $exception->getTrace(),
        ]
    );

    $contextExtractor
        ->expects('extract')
        ->once()
        ->andReturn($context);

    $contextExtractorLocator
        ->expects('get')
        ->once()
        ->andReturn($contextExtractor);

    $decoratedLogger
        ->expects('error')
        ->once()
        ->andReturnUsing(function (string $logMessage, array $logContext) use ($context): void {
            expect()
                ->and($logMessage)->toBe($context->message)
                ->and($logContext)->toBe($context->context);
        });

    $metricsPowerLogger->error($event, $options, $exception);
});

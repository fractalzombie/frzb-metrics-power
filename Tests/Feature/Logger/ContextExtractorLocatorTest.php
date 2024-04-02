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
use FRZB\Component\MetricsPower\Logger\ContextExtractorLocator;
use FRZB\Component\MetricsPower\Logger\ContextExtractorLocatorInterface;
use FRZB\Component\MetricsPower\Logger\Exception\ContextExtractorLocatorException;
use FRZB\Component\MetricsPower\Tests\Stub\Exception\SomethingGoesWrongException;
use FRZB\Component\MetricsPower\Tests\Stub\TestConstants;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;
use Symfony\Component\Messenger\Event\WorkerMessageReceivedEvent;
use Symfony\Component\Messenger\Event\WorkerMessageRetriedEvent;
use Symfony\Contracts\Service\ServiceProviderInterface;

uses(KernelTestCase::class);

beforeEach(function (): void {
    $this->ensureKernelShutdown();
    $this->bootKernel();
});

test(
    'It can extract event with custom extractor',
    function (object $target, string $extractorType, string $expectedMessage, array $expectedContext): void {
        $extractor = $this->getContainer()
            ->get(ContextExtractorLocatorInterface::class)
            ->get($target);

        $context = $extractor->extract($target);

        expect()
            ->and($extractor::getType())->toBe($extractorType)
            ->and($context->message)->toBe($expectedMessage);

        foreach ($expectedContext as $key) {
            expect($context->context)->toHaveKey($key);
        }
    }
)->with(function () {
    yield ClassHelper::getShortName(SendMessageToTransportsEvent::class) => [
        'event' => new SendMessageToTransportsEvent(createTestEnvelope(), [TestConstants::DEFAULT_RECEIVER_NAME]),
        'extractor_type' => SendMessageToTransportsEvent::class,
        'expected_message' => '[MetricsPower] [INFO] [MESSAGE: Message sent] [TARGET_CLASS: {target_class}]',
        'expected_context' => ['target_class', 'target_values', 'message_class', 'options_class', 'options_values'],
    ];

    yield ClassHelper::getShortName(WorkerMessageHandledEvent::class) => [
        'event' => new WorkerMessageHandledEvent(createTestEnvelope(), TestConstants::DEFAULT_RECEIVER_NAME),
        'extractor_type' => WorkerMessageHandledEvent::class,
        'expected_message' => '[MetricsPower] [INFO] [MESSAGE: Handle succeed] [OPTIONS_CLASS: {options_class}] [TARGET_CLASS: {target_class}] [MESSAGE_CLASS: {message_class}]',
        'expected_context' => ['target_class', 'target_values', 'message_class', 'message_values', 'options_class', 'options_values'],
    ];

    yield ClassHelper::getShortName(WorkerMessageReceivedEvent::class) => [
        'event' => new WorkerMessageReceivedEvent(createTestEnvelope(), TestConstants::DEFAULT_RECEIVER_NAME),
        'extractor_type' => WorkerMessageReceivedEvent::class,
        'expected_message' => '[MetricsPower] [INFO] [MESSAGE: Handle received] [OPTIONS_CLASS: {options_class}] [TARGET_CLASS: {target_class}] [MESSAGE_CLASS: {message_class}]',
        'expected_context' => ['target_class', 'target_values', 'message_class', 'message_values', 'options_class', 'options_values'],
    ];

    yield ClassHelper::getShortName(WorkerMessageRetriedEvent::class) => [
        'event' => new WorkerMessageRetriedEvent(createTestEnvelope(), TestConstants::DEFAULT_RECEIVER_NAME),
        'extractor_type' => WorkerMessageRetriedEvent::class,
        'expected_message' => '[MetricsPower] [INFO] [MESSAGE: Handle retried] [OPTIONS_CLASS: {options_class}] [TARGET_CLASS: {target_class}] [MESSAGE_CLASS: {message_class}]',
        'expected_context' => ['target_class', 'target_values', 'message_class', 'message_values', 'options_class', 'options_values'],
    ];
});

test('It can extract ExceptionEvent event', function (): void {
    $contextExtractorLocator = $this->getContainer()->get(ContextExtractorLocatorInterface::class);
    $kernel = \Mockery::mock(HttpKernelInterface::class);
    $request = createRequest();
    $target = new ExceptionEvent($kernel, $request, HttpKernelInterface::MAIN_REQUEST, SomethingGoesWrongException::wrong());

    $extractor = $contextExtractorLocator->get($target);
    $context = $extractor->extract($target);

    expect()
        ->and($extractor::getType())->toBe(ExceptionEvent::class)
        ->and($context->message)->toBe('[MetricsPower] [ERROR] [MESSAGE: Operation failed] [TARGET_CLASS: {target_class}] [EXCEPTION_CLASS: {exception_class}] [EXCEPTION_MESSAGE: {exception_message}]')
        ->and($context->context)->toHaveKey('target_class')
        ->and($context->context)->toHaveKey('target_values')
        ->and($context->context)->toHaveKey('exception_class')
        ->and($context->context)->toHaveKey('exception_message')
        ->and($context->context)->toHaveKey('exception_trace')
        ->and($context->context['target_class'])->toBe('ExceptionEvent')
        ->and($context->context['target_values'])->toBeJson();
});

test('It can extract WorkerMessageFailedEvent event', function (): void {
    $contextExtractorLocator = $this->getContainer()->get(ContextExtractorLocatorInterface::class);
    $target = new WorkerMessageFailedEvent(createTestEnvelope(), TestConstants::DEFAULT_RECEIVER_NAME, SomethingGoesWrongException::wrong());

    $extractor = $contextExtractorLocator->get($target);
    $context = $extractor->extract($target);

    expect()
        ->and($extractor::getType())->toBe(WorkerMessageFailedEvent::class)
        ->and($context->message)->toBe('[MetricsPower] [ERROR] [MESSAGE: Operation failed] [TARGET_CLASS: {target_class}] [EXCEPTION_CLASS: {exception_class}] [EXCEPTION_MESSAGE: {exception_message}]')
        ->and($context->context)->toHaveKey('target_class')
        ->and($context->context)->toHaveKey('target_values')
        ->and($context->context)->toHaveKey('exception_class')
        ->and($context->context)->toHaveKey('exception_message')
        ->and($context->context)->toHaveKey('exception_trace')
        ->and($context->context['target_class'])->toBe('WorkerMessageFailedEvent')
        ->and($context->context['target_values'])->toBeJson();
});

test('It can extract any event', function (): void {
    $contextExtractorLocator = $this->getContainer()->get(ContextExtractorLocatorInterface::class);
    $request = createRequest();
    $target = new RequestEvent(\Mockery::mock(HttpKernelInterface::class), $request, HttpKernelInterface::MAIN_REQUEST);

    $extractor = $contextExtractorLocator->get($target);

    $context = $extractor->extract($target);

    expect()
        ->and($extractor::getType())->toBe('Default')
        ->and($context->message)->toBe('[MetricsPower] [INFO] [MESSAGE: Operation succeed] [TARGET_CLASS: {target_class}]')
        ->and($context->context)->toHaveKey('target_class')
        ->and($context->context)->toHaveKey('target_values')
        ->and($context->context['target_class'])->toBe('RequestEvent')
        ->and($context->context['target_values'])->toBeJson();
});

test('It throws ContextExtractorLocatorException when ContainerException caught', function (): void {
    $serviceLocator = \Mockery::mock(ServiceProviderInterface::class);
    $contextExtractorLocator = new ContextExtractorLocator($serviceLocator);
    $request = createRequest();
    $target = new RequestEvent(\Mockery::mock(HttpKernelInterface::class), $request, HttpKernelInterface::MAIN_REQUEST);

    $serviceLocator
        ->expects('get')
        ->once()
        ->andThrow(new LogicException('Something goes wrong'));

    $contextExtractorLocator->get($target);
})->throws(ContextExtractorLocatorException::class);

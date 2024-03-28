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

use FRZB\Component\MetricsPower\Attribute\LoggerOptions;
use FRZB\Component\MetricsPower\Attribute\OptionsInterface;
use FRZB\Component\MetricsPower\Helper\ClassHelper;
use FRZB\Component\MetricsPower\Logger\ContextExtractorLocatorInterface;
use FRZB\Component\MetricsPower\Tests\Stub\Exception\SomethingGoesWrongException;
use FRZB\Component\MetricsPower\Tests\Stub\TestConstants;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
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

test(
    'It can extract event with custom extractor',
    function (object $target, OptionsInterface $options, string $extractorType, string $expectedMessage, array $expectedContext): void {
        $extractor = $this->getContainer()
            ->get(ContextExtractorLocatorInterface::class)
            ->get($target);

        $context = $extractor->extract($target, $options);

        expect()
            ->and($extractor::getType())->toBe($extractorType)
            ->and($context->message)->toBe($expectedMessage)
            ->and($context->context)->toBe($expectedContext);
    }
)->with(function () {
    $kernel = \Mockery::mock(HttpKernelInterface::class);
    $request = createRequest();

    yield ClassHelper::getShortName(ExceptionEvent::class) => [
        'event' => new ExceptionEvent(
            $kernel,
            $request,
            HttpKernelInterface::MAIN_REQUEST,
            SomethingGoesWrongException::wrong()
        ),
        'options' => new LoggerOptions(),
        'extractor_type' => ExceptionEvent::class,
        'expected_message' => '[MetricsPower] [ERROR] [MESSAGE: Operation failed] [TARGET_CLASS: {target_class}] [EXCEPTION_CLASS: {exception_class}] [EXCEPTION_MESSAGE: {exception_message}]',
        'expected_context' => [
            'target_class' => 'ExceptionEvent',
        ],
    ];

    yield ClassHelper::getShortName(SendMessageToTransportsEvent::class) => [
        'event' => new SendMessageToTransportsEvent(createTestEnvelope(), [TestConstants::DEFAULT_RECEIVER_NAME]),
        'options' => new LoggerOptions(),
        'extractor_type' => SendMessageToTransportsEvent::class,
        'expected_message' => '[MetricsPower] [INFO] [MESSAGE: Sent to transports {transport_name}] [OPTIONS_CLASS: {options_class}] [TARGET_CLASS: {target_class}] [MESSAGE_CLASS: {message_class}]',
        'expected_context' => [
            'target_class' => 'SendMessageToTransportsEvent',
            'message_class' => 'TestMessage',
            'transport_name' => 'test-receiver',
            'message_values' => '{"id":"ID-1234"}',
            'options_class' => 'LoggerOptions',
        ],
    ];

    yield ClassHelper::getShortName(WorkerMessageFailedEvent::class) => [
        'event' => new WorkerMessageFailedEvent(
            createTestEnvelope(),
            TestConstants::DEFAULT_RECEIVER_NAME,
            SomethingGoesWrongException::wrong()
        ),
        'options' => new LoggerOptions(),
        'extractor_type' => WorkerMessageFailedEvent::class,
        'expected_message' => '[MetricsPower] [ERROR] [MESSAGE: Handle failed] [TARGET_CLASS: {target_class}] [OPTIONS_CLASS: {options_class}] [MESSAGE_CLASS: {message_class}] [EXCEPTION_CLASS: {exception_class}] [EXCEPTION_MESSAGE: {exception_message}] [OPTIONS_VALUES: {option_values}]',
        'expected_context' => [
            'target_class' => 'WorkerMessageFailedEvent',
            'target_values' => '{"id":"ID-1234"}',
            'options_class' => 'LoggerOptions',
            'option_values' => ['isSerializable' => true],
        ],
    ];

    yield ClassHelper::getShortName(WorkerMessageHandledEvent::class) => [
        'event' => new WorkerMessageHandledEvent(createTestEnvelope(), TestConstants::DEFAULT_RECEIVER_NAME),
        'options' => new LoggerOptions(),
        'extractor_type' => WorkerMessageHandledEvent::class,
        'expected_message' => '[MetricsPower] [INFO] [MESSAGE: Handle succeed] [OPTIONS_CLASS: {options_class}] [TARGET_CLASS: {target_class}] [MESSAGE_CLASS: {message_class}]',
        'expected_context' => [
            'target_class' => 'WorkerMessageHandledEvent',
            'message_class' => 'TestMessage',
            'message_values' => '{"id":"ID-1234"}',
            'options_class' => 'LoggerOptions',
        ],
    ];

    yield ClassHelper::getShortName(WorkerMessageReceivedEvent::class) => [
        'event' => new WorkerMessageReceivedEvent(createTestEnvelope(), TestConstants::DEFAULT_RECEIVER_NAME),
        'options' => new LoggerOptions(),
        'extractor_type' => WorkerMessageReceivedEvent::class,
        'expected_message' => '[MetricsPower] [INFO] [MESSAGE: Handle received] [OPTIONS_CLASS: {options_class}] [TARGET_CLASS: {target_class}] [MESSAGE_CLASS: {message_class}]',
        'expected_context' => [
            'target_class' => 'WorkerMessageReceivedEvent',
            'message_class' => 'TestMessage',
            'message_values' => '{"id":"ID-1234"}',
            'options_class' => 'LoggerOptions',
        ],
    ];

    yield ClassHelper::getShortName(WorkerMessageRetriedEvent::class) => [
        'event' => new WorkerMessageRetriedEvent(createTestEnvelope(), TestConstants::DEFAULT_RECEIVER_NAME),
        'options' => new LoggerOptions(),
        'extractor_type' => WorkerMessageRetriedEvent::class,
        'expected_message' => '[MetricsPower] [INFO] [MESSAGE: Handle retried] [OPTIONS_CLASS: {options_class}] [TARGET_CLASS: {target_class}] [MESSAGE_CLASS: {message_class}]',
        'expected_context' => [
            'target_class' => 'WorkerMessageRetriedEvent',
            'message_class' => 'TestMessage',
            'message_values' => '{"id":"ID-1234"}',
            'options_class' => 'LoggerOptions',
        ],
    ];
});

test('It can extract any event', function (): void {
    $contextExtractorLocator = $this->getContainer()->get(ContextExtractorLocatorInterface::class);
    $request = createRequest();
    $target = new RequestEvent(\Mockery::mock(HttpKernelInterface::class), $request, HttpKernelInterface::MAIN_REQUEST);

    $extractor = $contextExtractorLocator->get($target);

    $context = $extractor->extract($target, new LoggerOptions());

    expect()
        ->and($extractor::getType())->toBe('Default')
        ->and($context->message)->toBe('[MetricsPower] [INFO] [MESSAGE: Operation succeed] [OPTIONS_CLASS: {options_class}] [TARGET_CLASS: {target_class}]')
        ->and($context->context)->toHaveKey('target_class')
        ->and($context->context)->toHaveKey('target_values')
        ->and($context->context['target_class'])->toBe('RequestEvent')
        ->and($context->context['target_values'])->toBeJson();
});

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

use FRZB\Component\MetricsPower\Attribute\PrometheusOptions;
use FRZB\Component\MetricsPower\Exception\MetricsRegistrationException;
use FRZB\Component\MetricsPower\Helper\ClassHelper;
use FRZB\Component\MetricsPower\OptionsResolver\Resolver\PrometheusOptionsResolver;
use FRZB\Component\MetricsPower\Tests\Stub\Exception\SomethingGoesWrongException;
use FRZB\Component\MetricsPower\Tests\Stub\TestConstants;
use Prometheus\Counter;
use Prometheus\Exception\MetricsRegistrationException as BaseMetricsRegistrationException;
use Prometheus\RegistryInterface;
use Symfony\Component\Messenger\Event\AbstractWorkerMessageEvent;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;
use Symfony\Component\Messenger\Event\WorkerMessageReceivedEvent;
use Symfony\Component\Messenger\Event\WorkerMessageRetriedEvent;

test('It can make needed counter name and increment', function (string $counterName, AbstractWorkerMessageEvent|SendMessageToTransportsEvent $event, PrometheusOptions $options): void {
    $counter = \Mockery::mock(Counter::class);
    $registry = \Mockery::mock(RegistryInterface::class);
    $prometheusOptionResolver = new PrometheusOptionsResolver(TestConstants::DEFAULT_NAMESPACE, $registry);

    $counter->expects('inc')->once();
    $registry->expects('getOrRegisterCounter')->once()
        ->andReturnUsing(function (string $namespace, string $name, string $help, array $labels = []) use ($counter, $counterName, $options) {
            expect()
                ->and($namespace)->toBe(TestConstants::DEFAULT_NAMESPACE)
                ->and($name)->toBe($counterName)
                ->and($help)->toBe($options->help)
                ->and($labels)->toBe($options->labels);

            return $counter;
        });

    // @noinspection PhpUnhandledExceptionInspection
    $prometheusOptionResolver->resolve($event, $options);
    expect($prometheusOptionResolver::getType())->toBe(PrometheusOptions::class);
})->with(function () {
    $envelope = createTestEnvelope();

    yield ClassHelper::getShortName(WorkerMessageHandledEvent::class) => [
        'counter_name' => 'test_receiver_test_name_handled',
        'event' => new WorkerMessageHandledEvent($envelope, TestConstants::DEFAULT_RECEIVER_NAME),
        'options' => new PrometheusOptions(TestConstants::DEFAULT_RECEIVER_NAME, 'test-name', 'test-help-first', ['type_one'], ['TestMessage']),
    ];

    yield ClassHelper::getShortName(WorkerMessageReceivedEvent::class) => [
        'counter_name' => 'test_receiver_test_name_received',
        'event' => new WorkerMessageReceivedEvent($envelope, TestConstants::DEFAULT_RECEIVER_NAME),
        'options' => new PrometheusOptions(TestConstants::DEFAULT_RECEIVER_NAME, 'test-name', 'test-help-second', ['type_two'], ['TestMessage']),
    ];

    yield ClassHelper::getShortName(WorkerMessageRetriedEvent::class) => [
        'counter_name' => 'test_receiver_test_name_retried',
        'event' => new WorkerMessageRetriedEvent($envelope, TestConstants::DEFAULT_RECEIVER_NAME),
        'options' => new PrometheusOptions(TestConstants::DEFAULT_RECEIVER_NAME, 'test-name', 'test-help-third', ['type_three'], ['TestMessage']),
    ];

    yield ClassHelper::getShortName(WorkerMessageFailedEvent::class) => [
        'counter_name' => 'test_receiver_test_name_failed',
        'event' => new WorkerMessageFailedEvent($envelope, TestConstants::DEFAULT_RECEIVER_NAME, SomethingGoesWrongException::wrong()),
        'options' => new PrometheusOptions(TestConstants::DEFAULT_RECEIVER_NAME, 'test-name', 'test-help-fourth', ['type_fourth'], ['TestMessage']),
    ];

    yield ClassHelper::getShortName(SendMessageToTransportsEvent::class) => [
        'counter_name' => 'test_receiver_test_name_sent',
        'event' => new SendMessageToTransportsEvent($envelope, [TestConstants::DEFAULT_RECEIVER_NAME]),
        'options' => new PrometheusOptions(TestConstants::DEFAULT_RECEIVER_NAME, 'test-name', 'test-help-fifth', ['type_fifth'], ['TestMessage']),
    ];
});

test('It can throw when registry fails', function (): void {
    $registry = \Mockery::mock(RegistryInterface::class);
    $prometheusOptionResolver = new PrometheusOptionsResolver(TestConstants::DEFAULT_NAMESPACE, $registry);

    $event = new WorkerMessageFailedEvent(createTestEnvelope(), TestConstants::DEFAULT_RECEIVER_NAME, SomethingGoesWrongException::wrong());
    $options = new PrometheusOptions(TestConstants::DEFAULT_RECEIVER_NAME, 'test-name', 'test-help', ['type'], ['TestMessage']);

    $registry->expects('getOrRegisterCounter')
        ->once()
        ->andThrow(new BaseMetricsRegistrationException('something goes wrong'));

    // @noinspection PhpUnhandledExceptionInspection
    $prometheusOptionResolver->resolve($event, $options);

    $this->expectExceptionMessage('something goes wrong');
})->throws(MetricsRegistrationException::class);

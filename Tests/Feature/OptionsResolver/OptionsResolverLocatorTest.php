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
use FRZB\Component\MetricsPower\Attribute\OptionsInterface;
use FRZB\Component\MetricsPower\Attribute\PrometheusOptions;
use FRZB\Component\MetricsPower\Exception\MetricsRegistrationException;
use FRZB\Component\MetricsPower\Helper\EnvelopeHelper;
use FRZB\Component\MetricsPower\Helper\MetricalHelper;
use FRZB\Component\MetricsPower\Logger\MetricsPowerLoggerInterface;
use FRZB\Component\MetricsPower\OptionResolver\OptionResolverLocatorInterface;
use FRZB\Component\MetricsPower\OptionResolver\Resolver\DefaultOptionResolver;
use FRZB\Component\MetricsPower\OptionResolver\Resolver\PrometheusOptionResolver;
use FRZB\Component\MetricsPower\Tests\Stub\Exception\SomethingGoesWrongException;
use FRZB\Component\MetricsPower\Tests\Stub\TestConstants;
use Prometheus\Counter;
use Prometheus\Exception\MetricsRegistrationException as BaseMetricsRegistrationException;
use Prometheus\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;

uses(KernelTestCase::class);

beforeEach(function (): void {
    $this->ensureKernelShutdown();
    $this->bootKernel();
});

test('It returns correct OptionsResolver when default options provided', function (): void {
    $message = createTestMessage();
    $envelope = EnvelopeHelper::wrap($message);
    $metrical = MetricalHelper::getFirstMetrical($message);
    $event = new SendMessageToTransportsEvent($envelope, [TestConstants::DEFAULT_RECEIVER_NAME]);
    $options = $metrical->options[0];

    $counter = Mockery::mock(Counter::class);
    $counter->expects('inc')->once();
    $registry = Mockery::mock(RegistryInterface::class);
    $registry->expects('getOrRegisterCounter')->once()->andReturn($counter);

    $prometheusOptionResolver = new PrometheusOptionResolver(TestConstants::DEFAULT_NAMESPACE, $registry);
    $this->getContainer()->set(PrometheusOptionResolver::class, $prometheusOptionResolver);

    $this->getContainer()->get(OptionResolverLocatorInterface::class)->get($options)($event, $options);
});

test('It returns correct OptionsResolver with unknown options', function (): void {
    $message = createTestMessage();
    $envelope = EnvelopeHelper::wrap($message);
    $metrical = MetricalHelper::getFirstMetrical($message);
    $sendEvent = new SendMessageToTransportsEvent($envelope, [TestConstants::DEFAULT_RECEIVER_NAME]);
    $failedEvent = new WorkerMessageFailedEvent($envelope, TestConstants::DEFAULT_RECEIVER_NAME, SomethingGoesWrongException::wrong());
    $options = $metrical->options[0];

    $logger = Mockery::mock(MetricsPowerLoggerInterface::class);
    $logger->expects('logInfo')->once();
    $logger->expects('logError')->once();

    $defaultOptionResolver = new DefaultOptionResolver($logger);
    $this->getContainer()->set(PrometheusOptionResolver::class, $defaultOptionResolver);

    $this->getContainer()->get(OptionResolverLocatorInterface::class)->get($options)($sendEvent, $options);
    $defaultOptionResolver = $this->getContainer()->get(OptionResolverLocatorInterface::class)->get($options);
    $defaultOptionResolver($failedEvent, $options);

    expect()
        ->and($defaultOptionResolver)->toBeInstanceOf(DefaultOptionResolver::class)
        ->and($defaultOptionResolver::getType())->toBe(OptionsInterface::class)
    ;
});

test('It throws MetricsRegistrationException when something goes wrong', function (): void {
    $message = createTestMessage();
    $envelope = EnvelopeHelper::wrap($message);
    $metrical = MetricalHelper::getFirstMetrical($message);
    $event = new SendMessageToTransportsEvent($envelope, [TestConstants::DEFAULT_RECEIVER_NAME]);
    $options = $metrical->options[0];

    $registry = Mockery::mock(RegistryInterface::class);
    $registry->expects('getOrRegisterCounter')
        ->once()
        ->andThrow(new BaseMetricsRegistrationException('something goes wrong'))
    ;

    $this->getContainer()->set(PrometheusOptionResolver::class, new PrometheusOptionResolver(TestConstants::DEFAULT_NAMESPACE, $registry));
    $prometheusOptionResolver = $this->getContainer()->get(OptionResolverLocatorInterface::class)->get($options)($event, $options);

    expect()
        ->and($prometheusOptionResolver)->toBeInstanceOf(PrometheusOptionResolver::class)
        ->and($prometheusOptionResolver::getType())->toBe(PrometheusOptions::class)
    ;
})->throws(MetricsRegistrationException::class);

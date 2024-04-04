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

namespace FRZB\Component\MetricsPower\Tests\Feature\Helper;

use FRZB\Component\MetricsPower\Attribute\LoggerOptions;
use FRZB\Component\MetricsPower\Attribute\Metrical;
use FRZB\Component\MetricsPower\Attribute\PrometheusOptions;
use FRZB\Component\MetricsPower\Helper\ClassHelper;
use FRZB\Component\MetricsPower\Helper\MetricalHelper;
use FRZB\Component\MetricsPower\Tests\Stub\Message\TestMessage;
use FRZB\Component\MetricsPower\Tests\Stub\Message\TestMessageWithNoOptions;
use FRZB\Component\MetricsPower\Tests\Stub\TestConstants;

test('it can show metrical or not', function (object $target, bool $isMetrical): void {
    expect()
        ->and(MetricalHelper::isMetrical($target))->toBe($isMetrical);
})->with([
    sprintf('%s', ClassHelper::getShortName(TestMessage::class)) => [
        'target' => createTestMessage(),
        'is_metrical' => true,
    ],
    sprintf('%s', ClassHelper::getShortName(TestMessageWithNoOptions::class)) => [
        'target' => new TestMessageWithNoOptions(TestConstants::DEFAULT_ID),
        'is_metrical' => false,
    ],
]);

test('it can get metrical attribute', function (object $target, ?string $metrical): void {
    $attribute = MetricalHelper::getMetrical($target);

    $attribute
        ? expect($attribute)->toBeInstanceOf($metrical)
        : expect($attribute)->toBeNull();
})->with([
    sprintf('%s', ClassHelper::getShortName(TestMessage::class)) => [
        'target_object' => createTestMessage(),
        'target_attribute' => Metrical::class,
    ],
    sprintf('%s', ClassHelper::getShortName(TestMessageWithNoOptions::class)) => [
        'target_object' => new TestMessageWithNoOptions(TestConstants::DEFAULT_ID),
        'target_attribute' => null,
    ],
]);

test('it can get options', function (object $target, ?string $optionsClass): void {
    $options = MetricalHelper::getOptions($target);

    $optionsClass
        ? expect(current($options))->toBeInstanceOf($optionsClass)
        : expect($options)->toBeEmpty();
})->with([
    sprintf('%s', ClassHelper::getShortName(TestMessage::class)) => [
        'target_object' => createTestMessage(),
        'target_attribute' => PrometheusOptions::class,
    ],
    sprintf('%s', ClassHelper::getShortName(TestMessageWithNoOptions::class)) => [
        'target_object' => new TestMessageWithNoOptions(TestConstants::DEFAULT_ID),
        'target_attribute' => null,
    ],
]);

test('it can get first options', function (object $target, ?string $attribute): void {
    $options = MetricalHelper::getFirstOptions($target);

    expect($options)->toBeInstanceOf($attribute);
})->with([
    sprintf('%s', ClassHelper::getShortName(TestMessage::class)) => [
        'target_object' => createTestMessage(),
        'target_attribute' => PrometheusOptions::class,
    ],
    sprintf('%s', ClassHelper::getShortName(TestMessageWithNoOptions::class)) => [
        'target_object' => new TestMessageWithNoOptions(TestConstants::DEFAULT_ID),
        'target_attribute' => LoggerOptions::class,
    ],
]);

test('it can get correct counter name', function (): void {
    $message = createTestMessage();

    /** @var PrometheusOptions $options */
    $options = MetricalHelper::getFirstOptions($message);
    $counterName = MetricalHelper::getCounterName($options);

    expect($counterName)->toBe('test_receiver_prometheus_default_options');
});

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

namespace FRZB\Component\MetricsPower\Tests\Unit\Helper;

use FRZB\Component\MetricsPower\Attribute\Metrical;
use FRZB\Component\MetricsPower\Helper\AttributeHelper;
use FRZB\Component\MetricsPower\Helper\ClassHelper;
use FRZB\Component\MetricsPower\Tests\Stub\Message\TestMessage;
use FRZB\Component\MetricsPower\Tests\Stub\Message\TestMessageWithAllOptions;
use FRZB\Component\MetricsPower\Tests\Stub\Message\TestMessageWithNoOptions;

dataset('messages', [
    sprintf('%s', ClassHelper::getShortName(TestMessage::class)) => [
        'class_name' => TestMessage::class,
        'has_attributes' => true,
    ],
    sprintf('%s', ClassHelper::getShortName(TestMessageWithAllOptions::class)) => [
        'class_name' => TestMessageWithAllOptions::class,
        'has_attributes' => true,
    ],
    sprintf('%s', ClassHelper::getShortName(TestMessageWithNoOptions::class)) => [
        'class_name' => TestMessageWithNoOptions::class,
        'has_attributes' => false,
    ],
    'InvalidClassName' => [
        'class_name' => 'InvalidClassName',
        'has_attributes' => false,
    ],
]);

test('It can get attributes', function (string $className, bool $hasAttributes): void {
    $hasAttributes
        ? expect(AttributeHelper::getAttributes($className, Metrical::class))->not()->toBeEmpty()
        : expect(AttributeHelper::getAttributes($className, Metrical::class))->toBeEmpty();
})->with('messages');

test('It can get attribute', function (string $className, bool $hasAttributes): void {
    $hasAttributes
        ? expect(AttributeHelper::getAttribute($className, Metrical::class))->not()->toBeEmpty()
        : expect(AttributeHelper::getAttribute($className, Metrical::class))->toBeEmpty();
})->with('messages');

test('It can get reflection attributes', function (string $className, bool $hasAttributes): void {
    $hasAttributes
        ? expect(AttributeHelper::getReflectionAttributes($className, Metrical::class))->not()->toBeEmpty()
        : expect(AttributeHelper::getReflectionAttributes($className, Metrical::class))->toBeEmpty();
})->with('messages');

test('It has attribute', function (string $className, bool $hasAttributes): void {
    expect(AttributeHelper::hasAttribute($className, Metrical::class))->toBe($hasAttributes);
})->with('messages');

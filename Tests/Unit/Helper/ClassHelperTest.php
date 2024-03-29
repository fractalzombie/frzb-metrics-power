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

use FRZB\Component\MetricsPower\Attribute\Metrical;
use FRZB\Component\MetricsPower\Helper\ClassHelper;
use FRZB\Component\MetricsPower\Tests\Stub\Message\TestMessage;
use FRZB\Component\MetricsPower\Tests\Stub\Message\TestMessageWithAllOptions;

test('it can get short name', function (string $className, string $shortClassName): void {
    expect($shortClassName)->toBe(ClassHelper::getShortName($className));
})->with([
    sprintf('%s', ClassHelper::getShortName(TestMessage::class)) => [
        'class_name' => TestMessage::class,
        'short_class_name' => 'TestMessage',
    ],
    sprintf('%s', ClassHelper::getShortName(TestMessageWithAllOptions::class)) => [
        'class_name' => TestMessageWithAllOptions::class,
        'short_class_name' => 'TestMessageWithAllOptions',
    ],
    'InvalidClassName' => [
        'class_name' => 'InvalidClassName',
        'short_class_name' => 'InvalidClassName',
    ],
]);

test('it can get reflection class', function (string $className, bool $isNull): void {
    $isNull
        ? expect(ClassHelper::getReflectionClass($className))->toBeNull()
        : expect(ClassHelper::getReflectionClass($className))->not()->toBeNull();
})->with([
    sprintf('%s', ClassHelper::getShortName(TestMessage::class)) => [
        'class_name' => TestMessage::class,
        'is_null' => false,
    ],
    sprintf('%s', ClassHelper::getShortName(TestMessageWithAllOptions::class)) => [
        'class_name' => TestMessageWithAllOptions::class,
        'is_null' => false,
    ],
    'InvalidClassName' => [
        'class_name' => 'InvalidClassName',
        'is_null' => true,
    ],
]);

test('it can get parent reflection class', function (string $className, bool $isNull): void {
    $isNull
        ? expect(ClassHelper::getParentReflectionClass($className))->toBeNull()
        : expect(ClassHelper::getParentReflectionClass($className))->not()->toBeNull();
})->with([
    sprintf('%s', ClassHelper::getShortName(TestMessage::class)) => [
        'class_name' => TestMessage::class,
        'is_null' => true,
    ],
    sprintf('%s', ClassHelper::getShortName(TestMessageWithAllOptions::class)) => [
        'class_name' => TestMessageWithAllOptions::class,
        'is_null' => true,
    ],
    'InvalidClassName' => [
        'class_name' => 'InvalidClassName',
        'is_null' => true,
    ],
]);

test('it can get reflection attributes class', function (string $className, bool $isNull): void {
    $isNull
        ? expect(ClassHelper::getReflectionAttributes($className, Metrical::class))->toBeEmpty()
        : expect(ClassHelper::getReflectionAttributes($className, Metrical::class))->not()->toBeEmpty();
})->with([
    sprintf('%s', ClassHelper::getShortName(TestMessage::class)) => [
        'class_name' => TestMessage::class,
        'is_empty' => false,
    ],
    sprintf('%s', ClassHelper::getShortName(TestMessageWithAllOptions::class)) => [
        'class_name' => TestMessageWithAllOptions::class,
        'is_empty' => false,
    ],
    'InvalidClassName' => [
        'class_name' => 'InvalidClassName',
        'is_null' => true,
    ],
]);

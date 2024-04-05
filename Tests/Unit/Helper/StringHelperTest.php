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

use FRZB\Component\MetricsPower\Helper\StringHelper;

test('It cannot be created', fn () => new StringHelper())->expectException(\Error::class);

test('It can normalize prefix', function (string $prefix, string $expectedValue): void {
    expect(StringHelper::normalize($prefix))->toBe($expectedValue);
})->with([
    ['some-domain.local', 'some-domain-local'],
    ['some%domain%local', 'some-domain-local'],
    ['some$domain$local', 'some-domain-local'],
    ['test-app.dev-tech.sub-domain.some-domain.cloud', 'test-app-dev-tech-sub-domain-some-domain-cloud'],
]);

test(
    'It can make prefix',
    function (string $prefix, string $expectedValue, ?string $value = null, ?string $delimiter = null): void {
        expect(StringHelper::makePrefix($prefix, $value, $delimiter))->toBe($expectedValue);
    }
)->with([
    ['some-domain.local', 'some-domain-local', null, '-'],
    ['some%domain%local', 'some-domain-local', null, '-'],
    ['some$domain$local', 'some-domain-local', null, '-'],
    ['test-app.dev-tech.sub-domain.some-domain.cloud', 'test-app-dev-tech-sub-domain-some-domain-cloud', null, '-'],
    ['some-domain.local', 'some-domain-local_prefix', 'prefix', '_'],
    ['some-domain.local', 'some-domain-local.prefix', 'prefix', '.'],
]);

test('It can convert to snake case', function (string $sourceValue, string $expectedValue): void {
    expect(StringHelper::toSnakeCase($sourceValue))->toBe($expectedValue);
})->with([
    ['SomeTrueValue', 'some_true_value'],
    ['SomeValue', 'some_value'],
    ['someValue', 'some_value'],
]);

test('It can convert to pascal case', function (string $sourceValue, string $expectedValue): void {
    expect(StringHelper::toPascalCase($sourceValue))->toBe($expectedValue);
})->with([
    ['camel_case_name', 'CamelCaseName'],
    ['camel_case', 'CamelCase'],
    ['camel', 'Camel'],
    ['camel-case', 'CamelCase'],
    ['camel-case-name', 'CamelCaseName'],
]);

test('It can convert to camel case', function (string $sourceValue, string $expectedValue): void {
    expect(StringHelper::toCamelCase($sourceValue))->toBe($expectedValue);
})->with([
    ['camel_case_name', 'camelCaseName'],
    ['camel_case', 'camelCase'],
    ['camel', 'camel'],
    ['camel-case', 'camelCase'],
    ['camel-case-name', 'camelCaseName'],
]);

test('It can convert to kebab case', function (string $sourceValue, string $expectedValue): void {
    expect(StringHelper::toKebabCase($sourceValue))->toBe($expectedValue);
})->with([
    ['SomeTrueValue', 'some-true-value'],
    ['SomeValue', 'some-value'],
    ['someValue', 'some-value'],
]);

test('It can check contains', function (string $sourceValue, string $subValue, bool $expectedValue): void {
    expect(StringHelper::contains($sourceValue, $subValue))->toBe($expectedValue);
})->with([
    ['SomeTrueValue', 'True', true],
    ['Hello my kitty', 'my', true],
    ['Bye bye', 'ye', true],
    ['SomeTrueValue', 'False', false],
    ['Hello my kitty', 'notmy', false],
    ['Bye bye', 'hello', false],
]);

test('It can remove brackets', function (string $inputValue, string $expectedValue, array $brackets): void {
    expect(StringHelper::removeBrackets($inputValue, $brackets))->toBe($expectedValue);
})->with([
    'standard brackets' => ['[hello_world]', 'hello_world', ['[', ']']],
    'curly brackets' => ['{hello_world}', 'hello_world', ['{', '}']],
]);

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

namespace FRZB\Component\MetricsPower\Tests\Unit\Traits;

use FRZB\Component\MetricsPower\Tests\Stub\Message\TestMessageWithPrivateConstructor;

test('It can not create instance from constructor', function (): void {
    /** @noinspection PhpUnhandledExceptionInspection */
    $ref = (new \ReflectionClass(TestMessageWithPrivateConstructor::create()));

    expect()
        ->and($ref->getName())->toBe(TestMessageWithPrivateConstructor::class)
        ->and($ref->getConstructor()->isPrivate())->toBeTrue();
});

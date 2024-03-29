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

use FRZB\Component\MetricsPower\Helper\ClassHelper;
use FRZB\Component\MetricsPower\Helper\EnvelopeHelper;
use FRZB\Component\MetricsPower\Tests\Stub\Message\TestMessage;
use FRZB\Component\MetricsPower\Tests\Stub\TestConstants;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

test('it can get short name', function (object $target): void {
    $envelope = EnvelopeHelper::wrap($target);
    $messageClass = $envelope->getMessage()::class;

    expect()
        ->and($envelope)->toBeInstanceOf(Envelope::class)
        ->and($messageClass)->toBe($envelope->getMessage()::class)
        ->and($envelope->last(DispatchAfterCurrentBusStamp::class))->not()->toBeNull();
})->with([
    sprintf('%s', ClassHelper::getShortName(TestMessage::class)) => [
        'target' => createTestMessage(),
        'has_attributes' => true,
    ],
    sprintf('%s', ClassHelper::getShortName(Envelope::class)) => [
        'target' => Envelope::wrap(new TestMessage(TestConstants::DEFAULT_ID)),
        'has_attributes' => false,
    ],
]);

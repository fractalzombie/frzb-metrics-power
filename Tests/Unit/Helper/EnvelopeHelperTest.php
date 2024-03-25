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

use FRZB\Component\MetricsPower\Helper\ClassHelper;
use FRZB\Component\MetricsPower\Helper\EnvelopeHelper;
use FRZB\Component\MetricsPower\Tests\Stub\Message\TransactionalOnTerminateMessage;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

/** @iternal */
#[Group('transactional-messenger')]
final class EnvelopeHelperTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testWrapMethod(object $target): void
    {
        $envelope = EnvelopeHelper::wrap($target);
        $messageClass = $envelope->getMessage()::class;

        self::assertInstanceOf(Envelope::class, $envelope);
        self::assertSame($messageClass, $envelope->getMessage()::class);
        self::assertNotNull($envelope->last(DispatchAfterCurrentBusStamp::class));
    }

    public function dataProvider(): iterable
    {
        yield sprintf('%s', ClassHelper::getShortName(TransactionalOnTerminateMessage::class)) => [
            'target' => new TransactionalOnTerminateMessage(),
            'has_attributes' => true,
        ];

        yield sprintf('%s', ClassHelper::getShortName(Envelope::class)) => [
            'target' => Envelope::wrap(new TransactionalOnTerminateMessage()),
            'has_attributes' => false,
        ];
    }
}

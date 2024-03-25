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

use FRZB\Component\MetricsPower\Enum\CommitType;
use FRZB\Component\MetricsPower\Helper\ClassHelper;
use FRZB\Component\MetricsPower\Helper\MetricalHelper;
use FRZB\Component\MetricsPower\Tests\Stub\Message\NonTransactionalMessage;
use FRZB\Component\MetricsPower\Tests\Stub\Message\TransactionalOnHandledMessage;
use FRZB\Component\MetricsPower\Tests\Stub\Message\TransactionalOnResponseMessage;
use FRZB\Component\MetricsPower\Tests\Stub\Message\TransactionalOnTerminateMessage;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

/** @iternal */
#[Group('transactional-messenger')]
final class TransactionHelperTest extends TestCase
{
    #[DataProvider('transactionalProvider')]
    public function testIsTransactionalMethod(string $className, bool $isTransactional): void
    {
        self::assertSame($isTransactional, MetricalHelper::isMetrical($className));
    }

    #[DataProvider('transactionalDataProvider')]
    public function getTransactionalMethod(string $className, bool $isTransactional): void
    {
        $isTransactional
            ? self::assertNotEmpty(MetricalHelper::getMetrical($className))
            : self::assertEmpty(MetricalHelper::getMetrical($className));
    }

    #[DataProvider('dispatchableProvider')]
    public function getIsDispatchableMethod(string $className, bool $isAllowed, array $commitTypes): void
    {
        self::assertSame($isAllowed, MetricalHelper::isDispatchable($className, ...$commitTypes));
    }

    public function transactionalProvider(): iterable
    {
        yield sprintf('%s', ClassHelper::getShortName(TransactionalOnTerminateMessage::class)) => [
            'class_name' => TransactionalOnTerminateMessage::class,
            'is_transactional' => true,
        ];

        yield sprintf('%s', ClassHelper::getShortName(TransactionalOnResponseMessage::class)) => [
            'class_name' => TransactionalOnResponseMessage::class,
            'is_transactional' => true,
        ];

        yield sprintf('%s', ClassHelper::getShortName(TransactionalOnHandledMessage::class)) => [
            'class_name' => TransactionalOnHandledMessage::class,
            'is_transactional' => true,
        ];

        yield sprintf('%s', ClassHelper::getShortName(NonTransactionalMessage::class)) => [
            'class_name' => NonTransactionalMessage::class,
            'is_transactional' => false,
        ];

        yield 'InvalidClassName' => [
            'class_name' => 'InvalidClassName',
            'is_transactional' => false,
        ];
    }

    public function dispatchableProvider(): iterable
    {
        yield sprintf('%s is allowed', ClassHelper::getShortName(TransactionalOnTerminateMessage::class)) => [
            'class_name' => TransactionalOnTerminateMessage::class,
            'is_allowed' => true,
            'commit_types' => [
                CommitType::OnTerminate,
            ],
        ];

        yield sprintf('%s is allowed', ClassHelper::getShortName(TransactionalOnResponseMessage::class)) => [
            'class_name' => TransactionalOnResponseMessage::class,
            'is_allowed' => true,
            'commit_types' => [
                CommitType::OnResponse,
            ],
        ];

        yield sprintf('%s is allowed', ClassHelper::getShortName(TransactionalOnHandledMessage::class)) => [
            'class_name' => TransactionalOnHandledMessage::class,
            'is_allowed' => true,
            'commit_types' => [
                CommitType::OnHandled,
            ],
        ];

        yield sprintf('%s is not allowed', ClassHelper::getShortName(TransactionalOnTerminateMessage::class)) => [
            'class_name' => TransactionalOnTerminateMessage::class,
            'is_allowed' => false,
            'commit_types' => [
                CommitType::OnResponse,
            ],
        ];

        yield sprintf('%s is not allowed', ClassHelper::getShortName(TransactionalOnResponseMessage::class)) => [
            'class_name' => TransactionalOnResponseMessage::class,
            'is_allowed' => false,
            'commit_types' => [
                CommitType::OnTerminate,
            ],
        ];

        yield sprintf('%s is not allowed', ClassHelper::getShortName(TransactionalOnHandledMessage::class)) => [
            'class_name' => TransactionalOnHandledMessage::class,
            'is_allowed' => false,
            'commit_types' => [
                CommitType::OnTerminate,
            ],
        ];

        yield sprintf('%s is not allowed', ClassHelper::getShortName(NonTransactionalMessage::class)) => [
            'class_name' => NonTransactionalMessage::class,
            'is_allowed' => false,
            'commit_types' => [],
        ];

        yield 'InvalidClassName is not allowed' => [
            'class_name' => 'InvalidClassName',
            'is_allowed' => false,
            'commit_types' => [],
        ];
    }
}

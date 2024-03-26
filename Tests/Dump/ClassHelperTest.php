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
// declare(strict_types=1);
//
// /**
// * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
// * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
// *
// * Copyright (c) 2024 Mykhailo Shtanko fractalzombie@gmail.com
// *
// * For the full copyright and license information, please view the LICENSE.MD
// * file that was distributed with this source code.
// */
//
// namespace FRZB\Component\MetricsPower\Tests\Unit\Dump;
//
// use FRZB\Component\MetricsPower\Attribute\Transactional;
// use FRZB\Component\MetricsPower\Helper\ClassHelper;
// use FRZB\Component\MetricsPower\Tests\Stub\Message\ExtendedTransactionalMessage;
// use FRZB\Component\MetricsPower\Tests\Stub\Message\NonTransactionalMessage;
// use FRZB\Component\MetricsPower\Tests\Stub\Message\TransactionalOnHandledMessage;
// use FRZB\Component\MetricsPower\Tests\Stub\Message\TransactionalOnResponseMessage;
// use FRZB\Component\MetricsPower\Tests\Stub\Message\TransactionalOnTerminateMessage;
// use PHPUnit\Framework\Attributes\DataProvider;
// use PHPUnit\Framework\Attributes\Group;
// use PHPUnit\Framework\TestCase;
//
// /** @iternal */
// #[Group('transactional-messenger')]
// final class ClassHelperTest extends TestCase
// {
//    #[DataProvider('shortNameProvider')]
//    public function testGetShortNameMethod(string $className, string $shortClassName): void
//    {
//        self::assertSame($shortClassName, ClassHelper::getShortName($className));
//    }
//
//    #[DataProvider('reflectionProvider')]
//    public function testGetReflectionClassMethod(string $className, bool $isNull): void
//    {
//        $isNull
//            ? self::assertNull(ClassHelper::getReflectionClass($className))
//            : self::assertNotNull(ClassHelper::getReflectionClass($className));
//    }
//
//    #[DataProvider('parentReflectionProvider')]
//    public function testGetParentReflectionClassMethod(string $className, bool $isNull): void
//    {
//        $isNull
//            ? self::assertNull(ClassHelper::getParentReflectionClass($className))
//            : self::assertNotNull(ClassHelper::getParentReflectionClass($className));
//    }
//
//    #[DataProvider('reflectionAttributesProvider')]
//    public function testGetReflectionAttributesClassMethod(string $className, bool $isEmpty): void
//    {
//        $isEmpty
//            ? self::assertEmpty(ClassHelper::getReflectionAttributes($className, Transactional::class))
//            : self::assertNotEmpty(ClassHelper::getReflectionAttributes($className, Transactional::class));
//    }
//
//    public function shortNameProvider(): iterable
//    {
//        yield sprintf('%s', ClassHelper::getShortName(TransactionalOnTerminateMessage::class)) => [
//            'class_name' => TransactionalOnTerminateMessage::class,
//            'short_class_name' => 'TransactionalOnTerminateMessage',
//        ];
//
//        yield sprintf('%s', ClassHelper::getShortName(TransactionalOnResponseMessage::class)) => [
//            'class_name' => TransactionalOnResponseMessage::class,
//            'short_class_name' => 'TransactionalOnResponseMessage',
//        ];
//
//        yield sprintf('%s', ClassHelper::getShortName(TransactionalOnHandledMessage::class)) => [
//            'class_name' => TransactionalOnHandledMessage::class,
//            'short_class_name' => 'TransactionalOnHandledMessage',
//        ];
//
//        yield sprintf('%s', ClassHelper::getShortName(NonTransactionalMessage::class)) => [
//            'class_name' => NonTransactionalMessage::class,
//            'short_class_name' => 'NonTransactionalMessage',
//        ];
//
//        yield 'InvalidClassName' => [
//            'class_name' => 'InvalidClassName',
//            'short_class_name' => 'InvalidClassName',
//        ];
//    }
//
//    public function reflectionProvider(): iterable
//    {
//        yield sprintf('%s', ClassHelper::getShortName(TransactionalOnTerminateMessage::class)) => [
//            'class_name' => TransactionalOnTerminateMessage::class,
//            'is_null' => false,
//        ];
//
//        yield sprintf('%s', ClassHelper::getShortName(TransactionalOnResponseMessage::class)) => [
//            'class_name' => TransactionalOnResponseMessage::class,
//            'is_null' => false,
//        ];
//
//        yield sprintf('%s', ClassHelper::getShortName(TransactionalOnHandledMessage::class)) => [
//            'class_name' => TransactionalOnHandledMessage::class,
//            'is_null' => false,
//        ];
//
//        yield sprintf('%s', ClassHelper::getShortName(ExtendedTransactionalMessage::class)) => [
//            'class_name' => ExtendedTransactionalMessage::class,
//            'is_null' => false,
//        ];
//
//        yield sprintf('%s', ClassHelper::getShortName(NonTransactionalMessage::class)) => [
//            'class_name' => NonTransactionalMessage::class,
//            'is_null' => false,
//        ];
//
//        yield 'InvalidClassName' => [
//            'class_name' => 'InvalidClassName',
//            'is_null' => true,
//        ];
//    }
//
//    public function parentReflectionProvider(): iterable
//    {
//        yield sprintf('%s', ClassHelper::getShortName(TransactionalOnTerminateMessage::class)) => [
//            'class_name' => TransactionalOnTerminateMessage::class,
//            'is_null' => true,
//        ];
//
//        yield sprintf('%s', ClassHelper::getShortName(TransactionalOnResponseMessage::class)) => [
//            'class_name' => TransactionalOnResponseMessage::class,
//            'is_null' => true,
//        ];
//
//        yield sprintf('%s', ClassHelper::getShortName(TransactionalOnHandledMessage::class)) => [
//            'class_name' => TransactionalOnHandledMessage::class,
//            'is_null' => true,
//        ];
//
//        yield sprintf('%s', ClassHelper::getShortName(ExtendedTransactionalMessage::class)) => [
//            'class_name' => ExtendedTransactionalMessage::class,
//            'is_null' => false,
//        ];
//
//        yield sprintf('%s', ClassHelper::getShortName(NonTransactionalMessage::class)) => [
//            'class_name' => NonTransactionalMessage::class,
//            'is_null' => true,
//        ];
//
//        yield 'InvalidClassName' => [
//            'class_name' => 'InvalidClassName',
//            'is_null' => true,
//        ];
//    }
//
//    public function reflectionAttributesProvider(): iterable
//    {
//        yield sprintf('%s', ClassHelper::getShortName(TransactionalOnTerminateMessage::class)) => [
//            'class_name' => TransactionalOnTerminateMessage::class,
//            'is_empty' => false,
//        ];
//
//        yield sprintf('%s', ClassHelper::getShortName(TransactionalOnResponseMessage::class)) => [
//            'class_name' => TransactionalOnResponseMessage::class,
//            'is_empty' => false,
//        ];
//
//        yield sprintf('%s', ClassHelper::getShortName(TransactionalOnHandledMessage::class)) => [
//            'class_name' => TransactionalOnHandledMessage::class,
//            'is_empty' => false,
//        ];
//
//        yield sprintf('%s', ClassHelper::getShortName(ExtendedTransactionalMessage::class)) => [
//            'class_name' => ExtendedTransactionalMessage::class,
//            'is_empty' => true,
//        ];
//
//        yield sprintf('%s', ClassHelper::getShortName(NonTransactionalMessage::class)) => [
//            'class_name' => NonTransactionalMessage::class,
//            'is_empty' => true,
//        ];
//
//        yield 'InvalidClassName' => [
//            'class_name' => 'InvalidClassName',
//            'is_empty' => true,
//        ];
//    }
// }

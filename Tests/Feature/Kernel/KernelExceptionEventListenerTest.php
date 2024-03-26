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

namespace FRZB\Component\MetricsPower\Tests\Feature\Kernel\Kernel;

use FRZB\Component\MetricsPower\EventListener\Kernel\KernelExceptionEventListener;
use FRZB\Component\MetricsPower\Tests\Stub\Exception\SomethingGoesWrongException;
use Sentry\State\HubInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

uses(KernelTestCase::class);

beforeEach(function (): void {
    $this->ensureKernelShutdown();
    $this->bootKernel();
});

test('It handles symfony messenger events', function (): void {
    $kernel = $this->kernel ?? $this->createKernel();
    $event = new ExceptionEvent($kernel, Request::createFromGlobals(), HttpKernelInterface::MAIN_REQUEST, SomethingGoesWrongException::wrong());
    $sentryHub = \Mockery::mock(HubInterface::class);

    $sentryHub
        ->expects('captureException')
        ->once();

    $this->getContainer()->set(HubInterface::class, $sentryHub);

    $this->getContainer()->get(KernelExceptionEventListener::class)($event);
});

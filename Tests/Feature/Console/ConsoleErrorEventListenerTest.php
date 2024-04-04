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

use FRZB\Component\MetricsPower\EventListener\Console\ConsoleErrorEventListener;
use FRZB\Component\MetricsPower\Tests\Stub\Exception\SomethingGoesWrongException;
use Sentry\State\HubInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

uses(KernelTestCase::class);

beforeEach(function (): void {
    $this->ensureKernelShutdown();
    $this->bootKernel();
});

test('It handles symfony messenger events', function (): void {
    $input = \Mockery::mock(InputInterface::class);
    $output = \Mockery::mock(OutputInterface::class);
    $event = new ConsoleErrorEvent($input, $output, SomethingGoesWrongException::wrong());
    $sentryHub = \Mockery::mock(HubInterface::class);

    $sentryHub
        ->expects('captureException')
        ->once();

    $this->getContainer()->set(HubInterface::class, $sentryHub);

    $this->getContainer()->get(ConsoleErrorEventListener::class)($event);
});

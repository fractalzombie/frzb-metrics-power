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

namespace FRZB\Component\MetricsPower\EventListener\Kernel;

use FRZB\Component\MetricsPower\Enum\ListenerPriority;
use Sentry\State\HubInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(KernelEvents::EXCEPTION, priority: ListenerPriority::HIGHEST)]
class KernelExceptionEventListener
{
    public function __construct(
        private readonly HubInterface $hub,
    ) {}

    public function __invoke(ExceptionEvent $event): void
    {
        $this->hub->captureException($event->getThrowable());
    }
}

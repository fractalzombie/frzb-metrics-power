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

namespace FRZB\Component\MetricsPower\Handler;

use FRZB\Component\DependencyInjection\Attribute\AsService;
use FRZB\Component\MetricsPower\Helper\MetricalHelper;
use FRZB\Component\MetricsPower\OptionsResolver\OptionsResolverLocatorInterface;

#[AsService]
class MetricsHandler implements MetricsHandlerInterface
{
    public function __construct(
        private readonly OptionsResolverLocatorInterface $locator,
    ) {}

    public function handle(object $event): void
    {
        foreach (MetricalHelper::getOptions($event->getEnvelope()->getMessage()) as $options) {
            if ($resolver = $this->locator->get($options)) {
                (new \Fiber($resolver->resolve(...)))->start($event, $options);
            }
        }
    }
}

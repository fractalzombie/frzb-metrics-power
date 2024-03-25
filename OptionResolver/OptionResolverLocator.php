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

namespace FRZB\Component\MetricsPower\OptionResolver;

use Fp\Collections\HashMap;
use FRZB\Component\DependencyInjection\Attribute\AsService;
use FRZB\Component\MetricsPower\Attribute\OptionsInterface;
use FRZB\Component\MetricsPower\OptionResolver\Resolver\DefaultOptionResolver;
use FRZB\Component\MetricsPower\OptionResolver\Resolver\OptionResolverInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

#[AsService]
class OptionResolverLocator implements OptionResolverLocatorInterface
{
    /** @var HashMap<string, OptionResolverInterface> */
    private readonly HashMap $resolvers;

    public function __construct(
        #[TaggedIterator(OptionResolverInterface::class, defaultIndexMethod: 'getType')]
        iterable $resolvers,
    ) {
        $this->resolvers = HashMap::collect($resolvers);
    }

    public function get(OptionsInterface $option): OptionResolverInterface
    {
        return $this->resolvers->get($option::class)->get()
            ?? $this->resolvers->get(DefaultOptionResolver::class)->getUnsafe();
    }
}

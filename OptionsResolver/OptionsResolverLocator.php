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

namespace FRZB\Component\MetricsPower\OptionsResolver;

use Fp\Collections\HashMap;
use FRZB\Component\DependencyInjection\Attribute\AsService;
use FRZB\Component\MetricsPower\Attribute\OptionsInterface;
use FRZB\Component\MetricsPower\OptionsResolver\Resolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

#[AsService]
class OptionsResolverLocator implements OptionsResolverLocatorInterface
{
    /** @var HashMap<string, OptionsResolverInterface> */
    private readonly HashMap $resolvers;

    public function __construct(
        #[TaggedIterator(OptionsResolverInterface::class, defaultIndexMethod: 'getType')]
        iterable $resolvers,
    ) {
        $this->resolvers = HashMap::collect($resolvers);
    }

    public function get(OptionsInterface $option): OptionsResolverInterface
    {
        return $this->resolvers->get($option::class)->get()
            ?? $this->resolvers->get(OptionsInterface::class)->getUnsafe();
    }
}

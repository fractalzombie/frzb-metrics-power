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

namespace FRZB\Component\MetricsPower\Logger;

use Fp\Collections\HashMap;
use FRZB\Component\DependencyInjection\Attribute\AsService;
use FRZB\Component\MetricsPower\Logger\ContextExtractor\ContextExtractorInterface;
use FRZB\Component\MetricsPower\Logger\ContextExtractor\DefaultContextExtractor;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

#[AsService]
final class ContextExtractorLocator implements ContextExtractorLocatorInterface
{
    /** @var HashMap<string, ContextExtractorInterface> */
    private readonly HashMap $resolvers;

    public function __construct(
        #[TaggedIterator(ContextExtractorInterface::class, defaultIndexMethod: 'getType')]
        iterable $resolvers,
    ) {
        $this->resolvers = HashMap::collect($resolvers);
    }

    public function get(object|string $target): ContextExtractorInterface
    {
        return $this->resolvers->get(\is_object($target) ? $target::class : $target)->get()
            ?? $this->resolvers->get(DefaultContextExtractor::DEFAULT_TYPE)->getUnsafe();
    }
}

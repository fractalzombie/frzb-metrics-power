<?php

/** @noinspection PhpIncompatibleReturnTypeInspection */

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

use FRZB\Component\DependencyInjection\Attribute\AsService;
use FRZB\Component\MetricsPower\Attribute\OptionsInterface;
use FRZB\Component\MetricsPower\OptionsResolver\Exception\OptionsResolverLocatorException;
use FRZB\Component\MetricsPower\OptionsResolver\Resolver\OptionsResolverInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedLocator;

#[AsService]
class OptionsResolverLocator implements OptionsResolverLocatorInterface
{
    public function __construct(
        #[TaggedLocator(OptionsResolverInterface::class, defaultIndexMethod: 'getType')]
        private readonly ContainerInterface $resolvers,
    ) {}

    public function get(OptionsInterface $option): ?OptionsResolverInterface
    {
        try {
            return $this->resolvers->get($option::class);
        } catch (NotFoundExceptionInterface) {
            return null;
        } catch (ContainerExceptionInterface $e) {
            throw OptionsResolverLocatorException::fromThrowable($e);
        }
    }
}

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

use FRZB\Component\DependencyInjection\Attribute\AsService;
use FRZB\Component\MetricsPower\Logger\ContextExtractor\ContextExtractorInterface;
use FRZB\Component\MetricsPower\Logger\ContextExtractor\DefaultContextExtractor;
use FRZB\Component\MetricsPower\Logger\Exception\ContextExtractorLocatorException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedLocator;
use Symfony\Contracts\Service\ServiceProviderInterface;

#[AsService]
final readonly class ContextExtractorLocator implements ContextExtractorLocatorInterface
{
    public function __construct(
        #[TaggedLocator(ContextExtractorInterface::class, defaultIndexMethod: 'getType')]
        private ServiceProviderInterface $serviceProvider,
    ) {}

    public function get(object|string $target): ContextExtractorInterface
    {
        try {
            return $this->serviceProvider->get(\is_object($target) ? $target::class : $target);
        } catch (NotFoundExceptionInterface) {
            return $this->serviceProvider->get(DefaultContextExtractor::getType());
        } catch (ContainerExceptionInterface $e) {
            throw ContextExtractorLocatorException::fromThrowable($e);
        }
    }
}

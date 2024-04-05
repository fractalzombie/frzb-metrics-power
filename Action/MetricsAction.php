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

namespace FRZB\Component\MetricsPower\Action;

use FRZB\Component\MetricsPower\Enum\Header;
use FRZB\Component\MetricsPower\Enum\HttpMethod;
use FRZB\Component\MetricsPower\Enum\StatusCode;
use FRZB\Component\MetricsPower\Exception\MetricsRenderException;
use Prometheus\RegistryInterface;
use Prometheus\RenderTextFormat;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final class MetricsAction
{
    public function __construct(
        private readonly RegistryInterface $registry,
    ) {}

    /** @throws MetricsRenderException */
    #[Route(methods: [HttpMethod::GET])]
    public function __invoke(): Response
    {
        try {
            return new Response(
                (new RenderTextFormat())->render($this->registry->getMetricFamilySamples()),
                StatusCode::OK,
                [Header::CONTENT_TYPE => RenderTextFormat::MIME_TYPE],
            );
        } catch (\Throwable $e) {
            throw MetricsRenderException::fromThrowable($e);
        }
    }
}

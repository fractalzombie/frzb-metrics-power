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

namespace FRZB\Component\MetricsPower\Logger\Processor;

use FRZB\Component\DependencyInjection\Attribute\AsTagged;
use Monolog\LogRecord;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsTagged('monolog.processor')]
class LogstashProcessor
{
    public function __construct(
        #[Autowire(env: 'MONOLOG_SOURCE')]
        private readonly string $source,
    ) {}

    public function __invoke(LogRecord $record): LogRecord
    {
        return new LogRecord(
            $record->datetime,
            $record->channel,
            $record->level,
            json_validate($record->message) ? $this->formatJson($record->message) : $record->message,
            $this->mapContext($record),
            $this->mapExtra($record),
            json_validate($record->formatted) ? $this->formatJson($record->formatted) : $record->formatted,
        );
    }

    private function formatJson(string $json): string
    {
        $decodedJson = json_decode($json, true);

        return json_encode($decodedJson, \JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE);
    }

    private function mapExtra(LogRecord $record): array
    {
        return [
            ...$record->extra,
            'source' => $this->source,
        ];
    }

    private function mapContext(LogRecord $record): array
    {
        return [
            ...$record->context,
        ];
    }
}

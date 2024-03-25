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

namespace FRZB\Component\MetricsPower\Enum;

enum HttpMethod: string
{
    case Head = 'HEAD';
    case Get = 'GET';
    case Post = 'POST';
    case Put = 'PUT';
    case Patch = 'PATCH';
    case Delete = 'DELETE';
    case Purge = 'PURGE';
    case Options = 'OPTIONS';
    case Trace = 'TRACE';
    case Connect = 'CONNECT';
    final public const HEAD = 'HEAD';
    final public const GET = 'GET';
    final public const POST = 'POST';
    final public const PUT = 'PUT';
    final public const PATCH = 'PATCH';
    final public const DELETE = 'DELETE';
    final public const PURGE = 'PURGE';
    final public const OPTIONS = 'OPTIONS';
    final public const TRACE = 'TRACE';
    final public const CONNECT = 'CONNECT';
}

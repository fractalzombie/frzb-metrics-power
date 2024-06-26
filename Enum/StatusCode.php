<?php

/** @noinspection PhpUnused */

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

enum StatusCode: int
{
    case Continue = 100;
    case SwitchingProtocols = 101;
    case Processing = 102;
    case EarlyHints = 103;
    case Ok = 200;
    case Created = 201;
    case Accepted = 202;
    case NonAuthoritativeInformation = 203;
    case NoContent = 204;
    case ResetContent = 205;
    case PartialContent = 206;
    case MultiStatus = 207;
    case AlreadyReported = 208;
    case ImUsed = 226;
    case MultipleChoices = 300;
    case MovedPermanently = 301;
    case Found = 302;
    case SeeOther = 303;
    case NotModified = 304;
    case UseProxy = 305;
    case Reserved = 306;
    case TemporaryRedirect = 307;
    case PermanentlyRedirect = 308;
    case BadRequest = 400;
    case Unauthorized = 401;
    case PaymentRequired = 402;
    case Forbidden = 403;
    case NotFound = 404;
    case MethodNotAllowed = 405;
    case NotAcceptable = 406;
    case ProxyAuthenticationRequired = 407;
    case RequestTimeout = 408;
    case Conflict = 409;
    case Gone = 410;
    case LengthRequired = 411;
    case PreconditionFailed = 412;
    case RequestEntityTooLarge = 413;
    case RequestUriTooLong = 414;
    case UnsupportedMediaType = 415;
    case RequestedRangeNotSatisfiable = 416;
    case ExpectationFailed = 417;
    case IAmATeapot = 418;
    case MisdirectedRequest = 421;
    case UnprocessableEntity = 422;
    case Locked = 423;
    case FailedDependency = 424;
    case TooEarly = 425;
    case UpgradeRequired = 426;
    case PreconditionRequired = 428;
    case TooManyRequests = 429;
    case RequestHeaderFieldsTooLarge = 431;
    case UnavailableForLegalReasons = 451;
    case InternalServerError = 500;
    case NotImplemented = 501;
    case BadGateway = 502;
    case ServiceUnavailable = 503;
    case GatewayTimeout = 504;
    case VersionNotSupported = 505;
    case VariantAlsoNegotiatesExperimental = 506;
    case InsufficientStorage = 507;
    case LoopDetected = 508;
    case NotExtended = 510;
    case NetworkAuthenticationRequired = 511;
    final public const CONTINUE = 100;
    final public const SWITCHING_PROTOCOLS = 101;
    final public const PROCESSING = 102;
    final public const EARLY_HINTS = 103;
    final public const OK = 200;
    final public const CREATED = 201;
    final public const ACCEPTED = 202;
    final public const NON_AUTHORITATIVE_INFORMATION = 203;
    final public const NO_CONTENT = 204;
    final public const RESET_CONTENT = 205;
    final public const PARTIAL_CONTENT = 206;
    final public const MULTI_STATUS = 207;
    final public const ALREADY_REPORTED = 208;
    final public const IM_USED = 226;
    final public const MULTIPLE_CHOICES = 300;
    final public const MOVED_PERMANENTLY = 301;
    final public const FOUND = 302;
    final public const SEE_OTHER = 303;
    final public const NOT_MODIFIED = 304;
    final public const USE_PROXY = 305;
    final public const RESERVED = 306;
    final public const TEMPORARY_REDIRECT = 307;
    final public const PERMANENTLY_REDIRECT = 308;
    final public const BAD_REQUEST = 400;
    final public const UNAUTHORIZED = 401;
    final public const PAYMENT_REQUIRED = 402;
    final public const FORBIDDEN = 403;
    final public const NOT_FOUND = 404;
    final public const METHOD_NOT_ALLOWED = 405;
    final public const NOT_ACCEPTABLE = 406;
    final public const PROXY_AUTHENTICATION_REQUIRED = 407;
    final public const REQUEST_TIMEOUT = 408;
    final public const CONFLICT = 409;
    final public const GONE = 410;
    final public const LENGTH_REQUIRED = 411;
    final public const PRECONDITION_FAILED = 412;
    final public const REQUEST_ENTITY_TOO_LARGE = 413;
    final public const REQUEST_URI_TOO_LONG = 414;
    final public const UNSUPPORTED_MEDIA_TYPE = 415;
    final public const REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    final public const EXPECTATION_FAILED = 417;
    final public const I_AM_A_TEAPOT = 418;
    final public const MISDIRECTED_REQUEST = 421;
    final public const UNPROCESSABLE_ENTITY = 422;
    final public const LOCKED = 423;
    final public const FAILED_DEPENDENCY = 424;
    final public const TOO_EARLY = 425;
    final public const UPGRADE_REQUIRED = 426;
    final public const PRECONDITION_REQUIRED = 428;
    final public const TOO_MANY_REQUESTS = 429;
    final public const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
    final public const UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    final public const INTERNAL_SERVER_ERROR = 500;
    final public const NOT_IMPLEMENTED = 501;
    final public const BAD_GATEWAY = 502;
    final public const SERVICE_UNAVAILABLE = 503;
    final public const GATEWAY_TIMEOUT = 504;
    final public const VERSION_NOT_SUPPORTED = 505;
    final public const VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;
    final public const INSUFFICIENT_STORAGE = 507;
    final public const LOOP_DETECTED = 508;
    final public const NOT_EXTENDED = 510;
    final public const NETWORK_AUTHENTICATION_REQUIRED = 511;
}

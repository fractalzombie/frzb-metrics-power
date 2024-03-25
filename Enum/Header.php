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

/**
 * HTTP Headers based on IANA Message Headers Registry and Wikipedia list.
 *
 * @see https://www.iana.org/assignments/message-headers/message-headers.xml#perm-headers
 * @see https://www.iana.org/assignments/message-headers/message-headers.xml#prov-headers
 * @see https://en.wikipedia.org/wiki/List_of_HTTP_header_fields#Common_non-standard_request_fields
 * @see https://en.wikipedia.org/wiki/List_of_HTTP_header_fields#Common_non-standard_response_fields
 */
interface Header
{
    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const A_IM = 'A-IM';

    /** @see https://tools.ietf.org/html/rfc7231#section-5.3.2 */
    final public const ACCEPT = 'Accept';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const ACCEPT_ADDITIONS = 'Accept-Additions';

    /** @see https://tools.ietf.org/html/rfc7231#section-5.3.3 */
    final public const ACCEPT_CHARSET = 'Accept-Charset';

    /** @see https://tools.ietf.org/html/rfc7089 */
    final public const ACCEPT_DATETIME = 'Accept-Datetime';

    /**
     * @see https://tools.ietf.org/html/rfc7231#section-5.3.4
     * @see https://tools.ietf.org/html/rfc7694#section-3
     */
    final public const ACCEPT_ENCODING = 'Accept-Encoding';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const ACCEPT_FEATURES = 'Accept-Features';

    /** @see https://tools.ietf.org/html/rfc7231#section-5.3.5 */
    final public const ACCEPT_LANGUAGE = 'Accept-Language';

    /** @see https://tools.ietf.org/html/rfc5789 */
    final public const ACCEPT_PATCH = 'Accept-Patch';

    /** @see https://www.w3.org/TR/ldp/ */
    final public const ACCEPT_POST = 'Accept-Post';

    /** @see https://tools.ietf.org/html/rfc7233#section-2.3 */
    final public const ACCEPT_RANGES = 'Accept-Ranges';

    final public const APPLICATION = 'app';

    /** @see https://tools.ietf.org/html/rfc7234#section-5.1 */
    final public const AGE = 'Age';

    /** @see https://tools.ietf.org/html/rfc7231#section-7.4.1 */
    final public const ALLOW = 'Allow';

    /** @see https://tools.ietf.org/html/rfc7639#section-2 */
    final public const ALPN = 'ALPN';

    /** @see https://tools.ietf.org/html/rfc7838 */
    final public const ALT_SVC = 'Alt-Svc';

    /** @see https://tools.ietf.org/html/rfc7838 */
    final public const ALT_USED = 'Alt-Used';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const ALTERNATES = 'Alternates';

    /** @see https://tools.ietf.org/html/rfc4437 */
    final public const APPLY_TO_REDIRECT_REF = 'Apply-To-Redirect-Ref';

    /** @see https://tools.ietf.org/html/rfc8053#section-4 */
    final public const AUTHENTICATION_CONTROL = 'Authentication-Control';

    /** @see https://tools.ietf.org/html/rfc7615#section-3 */
    final public const AUTHENTICATION_INFO = 'Authentication-Info';

    /** @see https://tools.ietf.org/html/rfc7235#section-4.2 */
    final public const AUTHORIZATION = 'Authorization';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const C_EXT = 'C-Ext';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const C_MAN = 'C-Man';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const C_OPT = 'C-Opt';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const C_PEP = 'C-PEP';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const C_PEP_INFO = 'C-PEP-Info';

    /** @see https://tools.ietf.org/html/rfc7234#section-5.2 */
    final public const CACHE_CONTROL = 'Cache-Control';

    /** @see https://tools.ietf.org/html/rfc7809#section-7.1 */
    final public const CALDAV_TIMEZONES = 'CalDAV-Timezones';

    /** @see https://tools.ietf.org/html/rfc7230#section-8.1 */
    final public const CLOSE = 'Close';

    /** @see https://tools.ietf.org/html/rfc7230#section-6.1 */
    final public const CONNECTION = 'Connection';

    /**
     * @see https://tools.ietf.org/html/rfc2068
     * @deprecated
     */
    final public const CONTENT_BASE = 'Content-Base';

    /** @see https://tools.ietf.org/html/rfc6266 */
    final public const CONTENT_DISPOSITION = 'Content-Disposition';

    /** @see https://tools.ietf.org/html/rfc7231#section-3.1.2.2 */
    final public const CONTENT_ENCODING = 'Content-Encoding';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const CONTENT_ID = 'Content-ID';

    /** @see https://tools.ietf.org/html/rfc7231#section-3.1.3.2 */
    final public const CONTENT_LANGUAGE = 'Content-Language';

    /** @see https://tools.ietf.org/html/rfc7230#section-3.3.2 */
    final public const CONTENT_LENGTH = 'Content-Length';

    /** @see https://tools.ietf.org/html/rfc7231#section-3.1.4.2 */
    final public const CONTENT_LOCATION = 'Content-Location';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const CONTENT_MD5 = 'Content-MD5';

    /** @see https://tools.ietf.org/html/rfc7233#section-4.2 */
    final public const CONTENT_RANGE = 'Content-Range';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const CONTENT_SCRIPT_TYPE = 'Content-Script-Type';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const CONTENT_STYLE_TYPE = 'Content-Style-Type';

    /** @see https://tools.ietf.org/html/rfc7231#section-3.1.1.5 */
    final public const CONTENT_TYPE = 'Content-Type';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const CONTENT_VERSION = 'Content-Version';

    /** @see https://tools.ietf.org/html/rfc6265 */
    final public const COOKIE = 'Cookie';

    /**
     * @see https://tools.ietf.org/html/rfc2965
     * @deprecated
     */
    final public const COOKIE2 = 'Cookie2';

    /** @see https://tools.ietf.org/html/rfc5323 */
    final public const DASL = 'DASL';

    /** @see https://tools.ietf.org/html/rfc4918 */
    final public const DAV = 'DAV';

    /** @see https://tools.ietf.org/html/rfc7231#section-7.1.1.2 */
    final public const DATE = 'Date';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const DEFAULT_STYLE = 'Default-Style';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const DELTA_BASE = 'Delta-Base';

    /** @see https://tools.ietf.org/html/rfc4918 */
    final public const DEPTH = 'Depth';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const DERIVED_FROM = 'Derived-From';

    /** @see https://tools.ietf.org/html/rfc4918 */
    final public const DESTINATION = 'Destination';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const DIFFERENTIAL_ID = 'Differential-ID';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const DIGEST = 'Digest';

    /** @see https://tools.ietf.org/html/rfc7232#section-2.3 */
    final public const ETAG = 'ETag';

    /** @see https://tools.ietf.org/html/rfc7231#section-5.1.1 */
    final public const EXPECT = 'Expect';

    /** @see https://tools.ietf.org/html/rfc7234#section-5.3 */
    final public const EXPIRES = 'Expires';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const EXT = 'Ext';

    /** @see https://tools.ietf.org/html/rfc7239 */
    final public const FORWARDED = 'Forwarded';

    /** @see https://tools.ietf.org/html/rfc7231#section-5.5.1 */
    final public const FROM = 'From';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const GETPROFILE = 'GetProfile';

    /** @see https://tools.ietf.org/html/rfc7486#section-6.1.1 */
    final public const HOBAREG = 'Hobareg';

    /** @see https://tools.ietf.org/html/rfc7230#section-5.4 */
    final public const HOST = 'Host';

    /** @see https://tools.ietf.org/html/rfc7540#section-3.2.1 */
    final public const HTTP2_SETTINGS = 'HTTP2-Settings';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const IM = 'IM';

    /** @see https://tools.ietf.org/html/rfc4918 */
    final public const IF = 'If';

    /** @see https://tools.ietf.org/html/rfc7232#section-3.1 */
    final public const IF_MATCH = 'If-Match';

    /** @see https://tools.ietf.org/html/rfc7232#section-3.3 */
    final public const IF_MODIFIED_SINCE = 'If-Modified-Since';

    /** @see https://tools.ietf.org/html/rfc7232#section-3.2 */
    final public const IF_NONE_MATCH = 'If-None-Match';

    /** @see https://tools.ietf.org/html/rfc7233#section-3.2 */
    final public const IF_RANGE = 'If-Range';

    /** @see https://tools.ietf.org/html/rfc6638 */
    final public const IF_SCHEDULE_TAG_MATCH = 'If-Schedule-Tag-Match';

    /** @see https://tools.ietf.org/html/rfc7232#section-3.4 */
    final public const IF_UNMODIFIED_SINCE = 'If-Unmodified-Since';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const KEEP_ALIVE = 'Keep-Alive';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const LABEL = 'Label';

    /** @see https://tools.ietf.org/html/rfc7232#section-2.2 */
    final public const LAST_MODIFIED = 'Last-Modified';

    /** @see https://tools.ietf.org/html/rfc5988 */
    final public const LINK = 'Link';

    /** @see https://tools.ietf.org/html/rfc7231#section-7.1.2 */
    final public const LOCATION = 'Location';

    /** @see https://tools.ietf.org/html/rfc4918 */
    final public const LOCK_TOKEN = 'Lock-Token';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const MAN = 'Man';

    /** @see https://tools.ietf.org/html/rfc7231#section-5.1.2 */
    final public const MAX_FORWARDS = 'Max-Forwards';

    /** @see https://tools.ietf.org/html/rfc7089 */
    final public const MEMENTO_DATETIME = 'Memento-Datetime';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const METER = 'Meter';

    /** @see https://tools.ietf.org/html/rfc7231 */
    final public const MIME_VERSION = 'MIME-Version';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const NEGOTIATE = 'Negotiate';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const OPT = 'Opt';

    /** @see https://tools.ietf.org/html/rfc8053#section-3 */
    final public const OPTIONAL_WWW_AUTHENTICATE = 'Optional-WWW-Authenticate';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const ORDERING_TYPE = 'Ordering-Type';

    /** @see https://tools.ietf.org/html/rfc6454 */
    final public const ORIGIN = 'Origin';

    /** @see https://tools.ietf.org/html/rfc4918 */
    final public const OVERWRITE = 'Overwrite';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const P3P = 'P3P';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const PEP = 'PEP';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const PICS_LABEL = 'PICS-Label';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const PEP_INFO = 'Pep-Info';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const POSITION = 'Position';

    /** @see https://tools.ietf.org/html/rfc7234#section-5.4 */
    final public const PRAGMA = 'Pragma';

    /** @see https://tools.ietf.org/html/rfc7240 */
    final public const PREFER = 'Prefer';

    /** @see https://tools.ietf.org/html/rfc7240 */
    final public const PREFERENCE_APPLIED = 'Preference-Applied';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const PROFILEOBJECT = 'ProfileObject';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const PROTOCOL = 'Protocol';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const PROTOCOL_INFO = 'Protocol-Info';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const PROTOCOL_QUERY = 'Protocol-Query';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const PROTOCOL_REQUEST = 'Protocol-Request';

    /** @see https://tools.ietf.org/html/rfc7235#section-4.3 */
    final public const PROXY_AUTHENTICATE = 'Proxy-Authenticate';

    /** @see https://tools.ietf.org/html/rfc7615#section-4 */
    final public const PROXY_AUTHENTICATION_INFO = 'Proxy-Authentication-Info';

    /** @see https://tools.ietf.org/html/rfc7235#section-4.4 */
    final public const PROXY_AUTHORIZATION = 'Proxy-Authorization';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const PROXY_FEATURES = 'Proxy-Features';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const PROXY_INSTRUCTION = 'Proxy-Instruction';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const PUBLIC = 'Public';

    /** @see https://tools.ietf.org/html/rfc7469 */
    final public const PUBLIC_KEY_PINS = 'Public-Key-Pins';

    /** @see https://tools.ietf.org/html/rfc7469 */
    final public const PUBLIC_KEY_PINS_REPORT_ONLY = 'Public-Key-Pins-Report-Only';

    /** @see https://tools.ietf.org/html/rfc7233#section-3.1 */
    final public const RANGE = 'Range';

    /** @see https://tools.ietf.org/html/rfc4437 */
    final public const REDIRECT_REF = 'Redirect-Ref';

    /** @see https://tools.ietf.org/html/rfc7231#section-5.5.2 */
    final public const REFERER = 'Referer';

    /** @see https://tools.ietf.org/html/rfc7231#section-7.1.3 */
    final public const RETRY_AFTER = 'Retry-After';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const SAFE = 'Safe';

    /** @see https://tools.ietf.org/html/rfc6638 */
    final public const SCHEDULE_REPLY = 'Schedule-Reply';

    /** @see https://tools.ietf.org/html/rfc6638 */
    final public const SCHEDULE_TAG = 'Schedule-Tag';

    /** @see https://tools.ietf.org/html/rfc6455 */
    final public const SEC_WEBSOCKET_ACCEPT = 'Sec-WebSocket-Accept';

    /** @see https://tools.ietf.org/html/rfc6455 */
    final public const SEC_WEBSOCKET_EXTENSIONS = 'Sec-WebSocket-Extensions';

    /** @see https://tools.ietf.org/html/rfc6455 */
    final public const SEC_WEBSOCKET_KEY = 'Sec-WebSocket-Key';

    /** @see https://tools.ietf.org/html/rfc6455 */
    final public const SEC_WEBSOCKET_PROTOCOL = 'Sec-WebSocket-Protocol';

    /** @see https://tools.ietf.org/html/rfc6455 */
    final public const SEC_WEBSOCKET_VERSION = 'Sec-WebSocket-Version';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const SECURITY_SCHEME = 'Security-Scheme';

    /** @see https://tools.ietf.org/html/rfc7231#section-7.4.2 */
    final public const SERVER = 'Server';

    /** @see https://tools.ietf.org/html/rfc6265 */
    final public const SET_COOKIE = 'Set-Cookie';

    /**
     * @see https://tools.ietf.org/html/rfc2965
     * @deprecated
     */
    final public const SET_COOKIE2 = 'Set-Cookie2';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const SETPROFILE = 'SetProfile';

    /** @see https://tools.ietf.org/html/rfc5023 */
    final public const SLUG = 'SLUG';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const SOAPACTION = 'SoapAction';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const STATUS_URI = 'Status-URI';

    /** @see https://tools.ietf.org/html/rfc6797 */
    final public const STRICT_TRANSPORT_SECURITY = 'Strict-Transport-Security';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const SURROGATE_CAPABILITY = 'Surrogate-Capability';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const SURROGATE_CONTROL = 'Surrogate-Control';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const TCN = 'TCN';

    /** @see https://tools.ietf.org/html/rfc7230#section-4.3 */
    final public const TE = 'TE';

    /** @see https://tools.ietf.org/html/rfc4918 */
    final public const TIMEOUT = 'Timeout';

    /** @see https://tools.ietf.org/html/rfc8030#section-5.4 */
    final public const TOPIC = 'Topic';

    /** @see https://tools.ietf.org/html/rfc7230#section-4.4 */
    final public const TRAILER = 'Trailer';

    /** @see https://tools.ietf.org/html/rfc7230#section-3.3.1 */
    final public const TRANSFER_ENCODING = 'Transfer-Encoding';

    /** @see https://tools.ietf.org/html/rfc8030#section-5.2 */
    final public const TTL = 'TTL';

    /** @see https://tools.ietf.org/html/rfc8030#section-5.3 */
    final public const URGENCY = 'Urgency';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const URI = 'URI';

    /** @see https://tools.ietf.org/html/rfc7230#section-6.7 */
    final public const UPGRADE = 'Upgrade';

    /** @see https://tools.ietf.org/html/rfc7231#section-5.5.3 */
    final public const USER_AGENT = 'User-Agent';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const VARIANT_VARY = 'Variant-Vary';

    /** @see https://tools.ietf.org/html/rfc7231#section-7.1.4 */
    final public const VARY = 'Vary';

    /** @see https://tools.ietf.org/html/rfc7230#section-5.7.1 */
    final public const VIA = 'Via';

    /** @see https://tools.ietf.org/html/rfc7235#section-4.1 */
    final public const WWW_AUTHENTICATE = 'WWW-Authenticate';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const WANT_DIGEST = 'Want-Digest';

    /** @see https://tools.ietf.org/html/rfc7234#section-5.5 */
    final public const WARNING = 'Warning';

    /** @see https://tools.ietf.org/html/rfc7034 */
    final public const X_FRAME_OPTIONS = 'X-Frame-Options';

    // Provisional Message Headers

    /** @deprecated */
    final public const ACCESS_CONTROL = 'Access-Control';

    /** @see https://fetch.spec.whatwg.org/#http-requests */
    final public const ACCESS_CONTROL_ALLOW_CREDENTIALS = 'Access-Control-Allow-Credentials';

    final public const ACCESS_CONTROL_ALLOW_HEADERS = 'Access-Control-Allow-Headers';

    final public const ACCESS_CONTROL_ALLOW_METHODS = 'Access-Control-Allow-Methods';

    final public const ACCESS_CONTROL_ALLOW_ORIGIN = 'Access-Control-Allow-Origin';

    final public const ACCESS_CONTROL_MAX_AGE = 'Access-Control-Max-Age';

    final public const ACCESS_CONTROL_REQUEST_METHOD = 'Access-Control-Request-Method';

    final public const ACCESS_CONTROL_REQUEST_HEADERS = 'Access-Control-Request-Headers';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const COMPLIANCE = 'Compliance';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const CONTENT_TRANSFER_ENCODING = 'Content-Transfer-Encoding';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const COST = 'Cost';

    /** @see https://tools.ietf.org/html/rfc6017 */
    final public const EDIINT_FEATURES = 'EDIINT-Features';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const MESSAGE_ID = 'Message-ID';

    /** @deprecated */
    final public const METHOD_CHECK = 'Method-Check';

    /** @deprecated */
    final public const METHOD_CHECK_EXPIRES = 'Method-Check-Expires';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const NON_COMPLIANCE = 'Non-Compliance';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const OPTIONAL = 'Optional';

    /** @deprecated */
    final public const REFERER_ROOT = 'Referer-Root';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const RESOLUTION_HINT = 'Resolution-Hint';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const RESOLVER_LOCATION = 'Resolver-Location';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const SUBOK = 'SubOK';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const SUBST = 'Subst';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const TITLE = 'Title';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const UA_COLOR = 'UA-Color';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const UA_MEDIA = 'UA-Media';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const UA_PIXELS = 'UA-Pixels';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const UA_RESOLUTION = 'UA-Resolution';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const UA_WINDOWPIXELS = 'UA-Windowpixels';

    /** @see https://tools.ietf.org/html/rfc4229 */
    final public const VERSION = 'Version';

    final public const X_DEVICE_ACCEPT = 'X-Device-Accept';

    final public const X_DEVICE_ACCEPT_CHARSET = 'X-Device-Accept-Charset';

    final public const X_DEVICE_ACCEPT_ENCODING = 'X-Device-Accept-Encoding';

    final public const X_DEVICE_ACCEPT_LANGUAGE = 'X-Device-Accept-Language';

    final public const X_DEVICE_USER_AGENT = 'X-Device-User-Agent';

    // Non-standard Headers

    /** @see https://www.w3.org/TR/CSP3/#csp-header */
    final public const CONTENT_SECURITY_POLICY = 'Content-Security-Policy';

    final public const DNT = 'DNT';

    final public const PROXY_CONNECTION = 'Proxy-Connection';

    final public const STATUS = 'Status';

    final public const UPGRADE_INSECURE_REQUESTS = 'Upgrade-Insecure-Requests';

    final public const X_CONTENT_DURATION = 'X-Content-Duration';

    final public const X_CONTENT_SECURITY_POLICY = 'X-Content-Security-Policy';

    final public const X_CONTENT_TYPE_OPTIONS = 'X-Content-Type-Options';

    final public const X_CORRELATION_ID = 'X-Correlation-ID';

    final public const X_PLATFORM_AUTH_TOKEN = 'X-Platform-Auth-Token';

    final public const X_CSRF_TOKEN = 'X-Csrf-Token';

    final public const X_FORWARDED_FOR = 'X-Forwarded-For';

    final public const X_FORWARDED_HOST = 'X-Forwarded-Host';

    final public const X_FORWARDED_PROTO = 'X-Forwarded-Proto';

    final public const X_HTTP_METHOD_OVERRIDE = 'X-Http-Method-Override';

    final public const X_POWERED_BY = 'X-Powered-By';

    final public const X_REQUEST_ID = 'X-Request-ID';

    final public const X_PAY_TOKEN = 'X-PAY-TOKEN';

    final public const X_CBH_CORRELATION_ID = 'X-CBH-CORRELATION-ID';

    final public const X_REQUESTED_WITH = 'X-Requested-With';

    final public const X_UA_COMPATIBLE = 'X-UA-Compatible';

    final public const X_UIDH = 'X-UIDH';

    final public const X_WAP_PROFILE = 'X-Wap-Profile';

    final public const X_WEBKIT_CSP = 'X-WebKit-CSP';

    final public const X_XSS_PROTECTION = 'X-XSS-Protection';

    final public const X_HTTP_HAS_ERROR = 'X-Http-Has-Error';
}

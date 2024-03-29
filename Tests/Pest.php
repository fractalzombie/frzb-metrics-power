<?php /** @noinspection PhpDocSignatureInspection */

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
use FRZB\Component\MetricsPower\Helper\EnvelopeHelper;
use FRZB\Component\MetricsPower\Tests\Stub\Message\TestMessage;
use FRZB\Component\MetricsPower\Tests\Stub\TestConstants;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use Sentry\State\HubInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Messenger\Envelope;

uses()
    ->group('feature')
    ->in('Feature');

uses()
    ->group('unit')
    ->in('Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

// expect()->extend('toBeOne', fn () => $this->toBe(1));

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function createTestMessage(): TestMessage
{
    return new TestMessage(TestConstants::DEFAULT_ID);
}

/**
 * @template TMessage
 *
 * @param ?TMessage $message
 *
 * @return Envelope<TMessage>
 */
function createTestEnvelope(?object $message = null): Envelope
{
    return EnvelopeHelper::wrap($message ?? createTestMessage());
}

function createRequest(): Request
{
    $request = Request::createFromGlobals();

    $request
        ->setSession(new Session());

    return $request;
}

<?php

use Lce\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testFactoryPreservesHttpfulDefaults(): void
    {
        $template = \Httpful\Request::init()->addHeader('X-Test', 'default')->timeoutIn(12);
        \Httpful\Request::ini($template);

        try {
            $request = Request::init(\Httpful\Http::POST, \Httpful\Mime::JSON);

            self::assertInstanceOf(Request::class, $request);
            self::assertSame(\Httpful\Http::POST, $request->method);
            self::assertSame(\Httpful\Mime::JSON, $request->content_type);
            self::assertSame(\Httpful\Mime::JSON, $request->expected_type);
            self::assertSame('default', $request->headers['X-Test']);
            self::assertSame(12, $request->timeout);
        } finally {
            \Httpful\Request::resetIni();
        }
    }

    public function testSendReleasesHandleWithoutDeprecations(): void
    {
        $request = new class extends Request {
            public function __construct() {}

            public function buildResponse($result)
            {
                return $result;
            }
        };
        $request->_ch = curl_init('file://' . __FILE__);
        curl_setopt($request->_ch, CURLOPT_RETURNTRANSFER, true);

        set_error_handler(function ($severity, $message, $file, $line) {
            throw new ErrorException($message, 0, $severity, $file, $line);
        });

        try {
            self::assertSame(file_get_contents(__FILE__), $request->send());
            self::assertNull($request->_ch);
            self::assertFalse($request->hasBeenInitialized());
        } finally {
            restore_error_handler();
        }
    }

    public function testSendReleasesHandleWhenResponseParsingFails(): void
    {
        $request = new class extends Request {
            public function __construct() {}

            public function buildResponse($result)
            {
                throw new RuntimeException('Invalid response');
            }
        };
        $request->_ch = curl_init('file://' . __FILE__);
        curl_setopt($request->_ch, CURLOPT_RETURNTRANSFER, true);

        try {
            $request->send();
            self::fail('Expected response parsing to fail.');
        } catch (RuntimeException $caught) {
            self::assertSame('Invalid response', $caught->getMessage());
        } finally {
            self::assertNull($request->_ch);
        }
    }
}
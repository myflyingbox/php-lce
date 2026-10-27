<?php

use Lce\Connection;
use Lce\Exception\LceException;
use Lce\PaginatedArray;
use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase
{
    public function testRejectsResponsesWithoutDataWithoutWarnings(): void
    {
        foreach ([(object) [], null, [], 'unexpected', (object) ['count' => 0, 'page' => 1, 'per_page' => 10]] as $body) {
            try {
                $this->sendResponse($body);
                self::fail('Expected an invalid response exception.');
            } catch (LceException $exception) {
                self::assertStringContainsString('missing "data" field (HTTP 200)', $exception->getMessage());
                self::assertStringContainsString('file://', $exception->getMessage());
            }
        }
    }

    public function testPreservesPresentDataIncludingNullAndEmptyValues(): void
    {
        foreach ([null, [], false, 0, '', ['example']] as $data) {
            self::assertSame($data, $this->sendResponse((object) ['data' => $data]));
        }
    }

    public function testPreservesPaginatedResponses(): void
    {
        $result = $this->sendResponse((object) [
            'data' => ['example'],
            'count' => 3,
            'page' => 1,
            'per_page' => 2,
        ]);

        self::assertInstanceOf(PaginatedArray::class, $result);
        self::assertSame(['example'], $result->getArrayCopy());
        self::assertSame(1, $result->current_page);
        self::assertSame(2, $result->per_page);
        self::assertSame(3, $result->total_count);
    }

    public function testPreservesApiErrors(): void
    {
        $this->expectException(LceException::class);
        $this->expectExceptionMessage('API unavailable');

        $this->sendResponse((object) [
            'error' => (object) ['message' => 'API unavailable', 'type' => 'unknown'],
        ], '503 Service Unavailable');
    }

    private function sendResponse($body, $status = '200 OK')
    {
        $fixture = tempnam(sys_get_temp_dir(), 'lce-response-');
        file_put_contents($fixture, "HTTP/1.1 " . $status . "\r\nContent-Type: application/json\r\n\r\n" . json_encode($body));
        $template = \Httpful\Request::init()->addOnCurlOption(CURLOPT_HEADER, false);
        \Httpful\Request::ini($template);

        set_error_handler(function ($severity, $message, $file, $line) {
            throw new ErrorException($message, 0, $severity, $file, $line);
        });

        try {
            $connection = new Connection('test', 'test', 'staging', '2', 'file://' . $fixture);
            return $connection->get();
        } finally {
            restore_error_handler();
            \Httpful\Request::resetIni();
            unlink($fixture);
        }
    }
}
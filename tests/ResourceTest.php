<?php

use PHPUnit\Framework\TestCase;

class ResourceTest extends TestCase
{
    public function testResourcesSupportDynamicPropertiesWithoutDeprecations(): void
    {
        $classes = [
            Lce\Resource\Resource::class,
            Lce\Resource\Offer::class,
            Lce\Resource\Order::class,
            Lce\Resource\Product::class,
            Lce\Resource\Quote::class,
        ];

        set_error_handler(function ($severity, $message, $file, $line) {
            throw new ErrorException($message, 0, $severity, $file, $line);
        });

        try {
            foreach ($classes as $class) {
                $resource = new $class((object) [
                    'id' => 'example-id',
                    'custom_api_field' => 'value',
                ]);
                $resource->additional_field = 'extra';

                self::assertSame('example-id', $resource->id);
                self::assertSame('value', $resource->custom_api_field);
                self::assertSame('extra', $resource->additional_field);
            }
        } finally {
            restore_error_handler();
        }
    }
}
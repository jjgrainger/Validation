<?php

use PHPUnit\Framework\TestCase;
use Tests\Fixtures\CustomProvider;
use Validation\Validator;

class CustomProviderTest extends TestCase
{
    public function test_it_registers_custom_assertions(): void
    {
        $validator = Validator::make(
            [
                'simple' => 'simpleAssertion',
                'extended' => 'extended:valid',
            ],
            [
                'providers' => [
                    new CustomProvider,
                ],
            ]
        );

        $result = $validator->validate([
            'simple' => 'valid',
            'extended' => 'valid',
        ]);

        $this->assertNull($result->messages()->first('simple'));
        $this->assertNull($result->messages()->first('extended'));
    }

    public function test_it_validates_using_custom_assertions_registered_by_provider(): void
    {
        $validator = Validator::make(
            [
                'simple' => 'simpleAssertion',
                'extended' => 'extended:valid',
            ],
            [
                'providers' => [
                    new CustomProvider,
                ],
            ]
        );

        $result = $validator->validate([
            'simple' => 'invalid',
            'extended' => 'invalid',
        ]);

        $this->assertSame('Invalid simple.', $result->messages()->first('simple'));
        $this->assertSame('Extended assertion failed for extended.', $result->messages()->first('extended'));
    }
}

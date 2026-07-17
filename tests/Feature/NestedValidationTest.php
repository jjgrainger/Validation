<?php

use PHPUnit\Framework\TestCase;
use Validation\Validator;

class NestedValidationTest extends TestCase
{
    public function test_it_passes_valid_nested_value(): void
    {
        $validator = Validator::make([
            'user.name' => 'required|string',
        ]);

        $result = $validator->validate([
            'user' => [
                'name' => 'Alice',
            ]
        ]);

        $this->assertNull($result->messages()->first('user.name'));
    }

    public function test_it_returns_error_for_invalid_nested_value(): void
    {
        $validator = Validator::make([
            'user.name' => 'required|string',
        ]);

        $result = $validator->validate([
            'user' => [
                'name' => '',
            ]
        ]);

        $this->assertSame('user.name is required.', $result->messages()->first('user.name'));
    }

    public function test_it_can_validate_deep_nested_selector(): void
    {
        $validator = Validator::make([
            'addresses.billing.postcode' => 'required|string',
        ]);

        $result = $validator->validate([
            'addresses' => [
                'billing' => [
                    'postcode' => '',
                ],
            ],
        ]);

        $this->assertSame('addresses.billing.postcode is required.', $result->messages()->first('addresses.billing.postcode'));
    }

    public function test_it_does_not_validate_when_intermediate_parent_is_missing(): void
    {
        $validator = Validator::make([
            'user.name' => 'required|string',
        ]);

        $result = $validator->validate([]);

        $this->assertSame(
            'user.name is required.',
            $result->messages()->first('user.name')
        );
    }

    public function test_it_validates_missing_nested_field(): void
    {
        $validator = Validator::make([
            'user.name' => 'required|string',
        ]);

        $result = $validator->validate([
            'user' => [],
        ]);

        $this->assertSame(
            'user.name is required.',
            $result->messages()->first('user.name')
        );
    }
}

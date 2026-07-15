<?php

use PHPUnit\Framework\TestCase;
use Validation\Validator;

class WildcardValidationTest extends TestCase
{
    public function test_it_can_validate_with_wildcard_selector()
    {
        $validator = Validator::make([
            'users.*.name' => 'required|string',
        ]);

        $result = $validator->validate([
            'users' => [
                ['name' => null],
                ['name' => 100],
                ['name' => 'admin'],
            ]
        ]);

        $this->assertEquals('users.0.name is required.', $result->messages()->first('users.0.name'));
        $this->assertEquals('users.1.name must be a string.', $result->messages()->first('users.1.name'));
        $this->assertNull($result->messages()->first('users.2.name'));
    }

    public function test_it_does_not_validate_empty_collection()
    {
        $validator = Validator::make([
            'users' => 'optional|array',
            'users.*.name' => 'required|string',
        ]);

        $result = $validator->validate([
            'users' => []
        ]);

        $this->assertNull($result->messages()->first('users'));
        $this->assertNull($result->messages()->first('users.0.name'));
    }
}

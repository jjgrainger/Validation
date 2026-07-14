<?php

use PHPUnit\Framework\TestCase;
use Validation\Input;

class InputTest extends TestCase
{
    public function test_it_returns_existing_attribute(): void
    {
        $input = new Input([
            'test' => 'test data.',
        ]);

        $attribute = $input->attribute('test');

        $this->assertSame('test', $attribute->key());
        $this->assertSame('test data.', $attribute->value());
        $this->assertTrue($attribute->exists());
    }

    public function test_it_returns_null_attribute_for_non_existing_attribute()
    {
        $input = new Input([]);

        $attribute = $input->attribute('test');

        $this->assertSame('test', $attribute->key());
        $this->assertNull($attribute->value());
        $this->assertFalse($attribute->exists());
    }

    public function test_it_returns_nested_attribute(): void
    {
        $input = new Input([
            'test' => 'test data.',
            'user' => [
                'name' => 'Admin',
                'email' => 'admin@example.com',
            ]
        ]);

        $name = $input->attribute('user.name');
        $email = $input->attribute('user.email');

        $this->assertSame('user.name', $name->key());
        $this->assertSame('Admin', $name->value());
        $this->assertTrue($name->exists());

        $this->assertSame('user.email', $email->key());
        $this->assertSame('admin@example.com', $email->value());
        $this->assertTrue($email->exists());
    }

    public function test_it_returns_null_attribute_for_non_existing_nested_attribute()
    {
        $input = new Input([
            'user' => [],
        ]);

        $attribute = $input->attribute('user.name');

        $this->assertSame('user.name', $attribute->key());
        $this->assertNull($attribute->value());
        $this->assertFalse($attribute->exists());
    }

    public function test_it_returns_attributes_for_wildcard_selector()
    {
        $input = new Input([
            'users' => [
                ['name' => 'Admin'],
                ['name' => 'Member'],
            ],
        ]);

        $attributes = $input->attributes('users.*.name');

        $this->assertCount(2, $attributes);
        $this->assertEquals('users.0.name', $attributes[0]->key());
        $this->assertEquals('Admin', $attributes[0]->value());
        $this->assertTrue($attributes[0]->exists());

        $this->assertEquals('users.1.name', $attributes[1]->key());
        $this->assertEquals('Member', $attributes[1]->value());
        $this->assertTrue($attributes[1]->exists());
    }

    public function test_it_returns_empty_collection_for_non_existing_wildcard_selector()
    {
        $input = new Input([
            'user' => [],
        ]);

        $attributes = $input->attributes('users.*.name');

        $this->assertEmpty($attributes);
    }

    public function test_it_returns_input()
    {
        $data = [
            'test' => 'test data.',
            'users' => [
                ['name' => 'Admin']
            ]
        ];

        $input = new Input($data);

        $this->assertEquals($data, $input->input());
    }
}

<?php

use PHPUnit\Framework\TestCase;
use Validation\Input;

class InputTest extends TestCase
{
    public function test_it_gets_values_from_data_passed(): void
    {
        $data = [
            'test' => 'test data.',
        ];

        $input = new Input($data);

        $this->assertSame($data['test'], $input->attribute('test')->value());
    }

    public function test_it_gets_with_dot_notated_attributes(): void
    {
        $data = [
            'test' => 'test data.',
            'author' => [
                'name' => 'Admin',
                'email' => 'admin@example.com',
            ]
        ];

        $input = new Input($data);

        $this->assertSame($data['test'], $input->attribute('test')->value());
        $this->assertSame($data['author']['name'], $input->attribute('author.name')->value());
        $this->assertSame($data['author']['email'], $input->attribute('author.email')->value());
    }
}

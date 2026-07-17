<?php

use PHPUnit\Framework\TestCase;
use Validation\Result;

class ResultTest extends TestCase
{
    public function test_it_can_add_message()
    {
        $result = new Result;

        $result->add('test', 'test message');

        $this->assertEquals(['test message'], $result->messages()->get('test'));
    }

    public function test_it_passes_without_messages()
    {
        $result = new Result;

        $this->assertTrue($result->passes());
        $this->assertFalse($result->fails());
    }

    public function test_it_fails_with_one_message()
    {
        $result = new Result;

        $result->add('test', 'test message');

        $this->assertTrue($result->fails());
        $this->assertFalse($result->passes());
    }

    public function test_it_can_return_result_as_array()
    {
        $result = new Result;

        $result->add('test', 'test message');

        $this->assertEquals(
            [
                'passes' => false,
                'fails' => true,
                'messages' => [
                    'test' => ['test message'],
                ],
            ],
            $result->toArray()
        );
    }

    public function test_it_can_return_result_as_json()
    {
        $result = new Result;

        $result->add('test', 'test message');

        $this->assertEquals(
            json_encode([
                'passes' => false,
                'fails' => true,
                'messages' => [
                    'test' => ['test message'],
                ],
            ]),
            $result->toJson()
        );
    }
}

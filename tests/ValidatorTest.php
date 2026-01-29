<?php

use PHPUnit\Framework\TestCase;
use Validation\Message;
use Validation\Rule;
use Validation\Validator;

class ValidatorTest extends TestCase
{
    public function test_it_passes_the_correct_value_to_rules(): void
    {
        $rule = $this->createMock(Rule::class);

        $rule->expects($this->once())
            ->method('validate')
            ->with('value')
            ->willReturn(true);

        $validator = new Validator([
            'test' => [$rule],
        ]);

        $result = $validator->validate([
            'test' => 'value',
        ]);

        $this->assertTrue($result->passes());
    }

    public function test_it_returns_errors_when_validation_fails()
    {
        $rule = $this->createMock(Rule::class);

        $rule->expects($this->once())
            ->method('validate')
            ->with('value')
            ->willReturn(false);

        $message = $this->createMock(Message::class);

        $message->expects($this->once())
            ->method('setReplacement')
            ->with(':attribute', 'test');

        $message->expects($this->once())
            ->method('build')
            ->willReturn('Invalid test.');

        $rule->expects($this->once())
            ->method('message')
            ->willReturn($message);

        $validator = new Validator([
            'test' => [$rule],
        ]);

        $result = $validator->validate([
            'test' => 'value',
        ]);

        $this->assertFalse($result->passes());
        $this->assertEquals('Invalid test.', $result->first('test'));
    }
}

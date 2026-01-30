<?php

use PHPUnit\Framework\TestCase;
use Validation\Message;
use Validation\Rule;
use Validation\Validator;

class ValidatorTest extends TestCase
{
    public function test_it_passes_the_correct_value_to_rules()
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

    public function test_it_does_not_add_messages_when_rules_pass()
    {
        $rule = $this->createMock(Rule::class);
        $rule->expects($this->once())
            ->method('validate')
            ->willReturn(true);

        $validator = new Validator([
            'test' => [$rule]
        ]);

        $result = $validator->validate([
            'test' => 'value'
        ]);

        $this->assertTrue($result->passes());
    }

    public function test_it_returns_messages_when_validation_fails()
    {
        $rule = $this->createMock(Rule::class);

        $rule->expects($this->once())
            ->method('validate')
            ->with('value')
            ->willReturn(false);

        $message = $this->createMock(Message::class);

        $message->expects($this->once())
            ->method('template')
            ->willReturn('Invalid :attribute.');

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

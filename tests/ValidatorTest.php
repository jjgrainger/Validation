<?php

use PHPUnit\Framework\TestCase;
use Validation\Contracts\InputContract;
use Validation\Contracts\RuleContract;
use Validation\Contracts\MessageContract;
use Validation\Rules\Signals\NeedsInput;
use Validation\Rules\Signals\SkipsOnFailure;
use Validation\Rules\Signals\StopsOnFailure;
use Validation\Validator;

class ValidatorTest extends TestCase
{
    public function test_it_passes_the_correct_value_to_rules()
    {
        $rule = $this->createMock(RuleContract::class);

        $rule->expects($this->once())
            ->method('validate')
            ->with('value')
            ->willReturn(true);

        $validator = Validator::make([
            'test' => [$rule],
        ]);

        $result = $validator->validate([
            'test' => 'value',
        ]);

        $this->assertTrue($result->passes());
    }

    public function test_it_does_not_add_messages_when_rules_pass()
    {
        $rule = $this->createMock(RuleContract::class);
        $rule->expects($this->once())
            ->method('validate')
            ->willReturn(true);

        $validator = Validator::make([
            'test' => [$rule]
        ]);

        $result = $validator->validate([
            'test' => 'value'
        ]);

        $this->assertTrue($result->passes());
    }

    public function test_it_returns_messages_when_validation_fails()
    {
        $message = $this->createMock(MessageContract::class);

        $message->expects($this->once())
            ->method('template')
            ->willReturn('Invalid :attribute.');

        $rule = $this->createMock(RuleContract::class);

        $rule->expects($this->once())
            ->method('validate')
            ->with('value')
            ->willReturn(false);

        $rule->expects($this->once())
            ->method('message')
            ->willReturn($message);

        $validator = Validator::make([
            'test' => [$rule],
        ]);

        $result = $validator->validate([
            'test' => 'value',
        ]);

        $this->assertFalse($result->passes());
        $this->assertEquals('Invalid test.', $result->first('test'));
    }

    public function test_it_stops_on_failure_for_rule()
    {
        $required = $this->createMockForIntersectionOfInterfaces([RuleContract::class, StopsOnFailure::class]);

        $required->expects($this->once())
            ->method('validate')
            ->with(null)
            ->willReturn(false);

        $bypassed = $this->createMock(RuleContract::class);

        $bypassed->expects($this->never())
            ->method('validate');

        $validator = Validator::make([
            'test' => [$required, $bypassed],
        ]);

        $result = $validator->validate([]);

        $this->assertTrue($result->fails());
        $this->assertCount(1, $result->get('test'));
    }

    public function test_it_skips_on_failure_for_rule()
    {
        $optional = $this->createMockForIntersectionOfInterfaces([RuleContract::class, SkipsOnFailure::class]);

        $optional->expects($this->once())
            ->method('validate')
            ->with(null)
            ->willReturn(false);

        $bypassed = $this->createMock(RuleContract::class);

        $bypassed->expects($this->never())
            ->method('validate');

        $validator = Validator::make([
            'test' => [$optional, $bypassed],
        ]);

        $result = $validator->validate([]);

        $this->assertTrue($result->passes());
        $this->assertEmpty($result->get('test'));
    }

    public function test_it_can_pass_input_to_rules()
    {
        $needsInput = $this->createMockForIntersectionOfInterfaces([RuleContract::class, NeedsInput::class]);

        $needsInput->expects($this->once())
            ->method('setInput')
            ->with($this->isInstanceOf(InputContract::class));

        $rule = $this->createMock(RuleContract::class);

        $rule->expects($this->once())
            ->method('validate')
            ->willReturn(true);

        $validator = Validator::make([
            'test' => [$needsInput, $rule],
        ]);

        $validator->validate([]);
    }
}

<?php

use PHPUnit\Framework\TestCase;
use Validation\Contracts\InputContract;
use Validation\Contracts\AssertionContract;
use Validation\Contracts\MessageContract;
use Validation\Assertions\Signals\RequiresInput;
use Validation\Assertions\Signals\SkipsOnFailure;
use Validation\Assertions\Signals\StopsOnFailure;
use Validation\Input;
use Validation\Validator;

class ValidatorTest extends TestCase
{
    public function test_it_passes_the_correct_value_to_rules()
    {
        $assertion = $this->createMock(AssertionContract::class);

        $assertion->expects($this->once())
            ->method('validate')
            ->with('value')
            ->willReturn(true);

        $validator = Validator::make([
            'test' => [$assertion],
        ]);

        $result = $validator->validate([
            'test' => 'value',
        ]);

        $this->assertTrue($result->passes());
    }

    public function test_it_does_not_add_messages_when_rules_pass()
    {
        $rule = $this->createMock(AssertionContract::class);
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

        $rule = $this->createMock(AssertionContract::class);

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
        $this->assertEquals('Invalid test.', $result->messages()->first('test'));
    }

    public function test_it_stops_on_failure_for_rule()
    {
        $required = $this->createMockForIntersectionOfInterfaces([AssertionContract::class, StopsOnFailure::class]);

        $required->expects($this->once())
            ->method('validate')
            ->with(null)
            ->willReturn(false);

        $bypassed = $this->createMock(AssertionContract::class);

        $bypassed->expects($this->never())
            ->method('validate');

        $validator = Validator::make([
            'test1' => [$required, $bypassed],
        ]);

        $result = $validator->validate([]);

        $this->assertTrue($result->fails());
        $this->assertCount(1, $result->messages()->get('test1'));
    }

    public function test_it_skips_on_failure_for_rule()
    {
        $optional = $this->createMockForIntersectionOfInterfaces([AssertionContract::class, SkipsOnFailure::class]);

        $optional->expects($this->once())
            ->method('validate')
            ->with(null)
            ->willReturn(false);

        $bypassed = $this->createMock(AssertionContract::class);

        $bypassed->expects($this->never())
            ->method('validate');

        $validator = Validator::make([
            'test' => [$optional, $bypassed],
        ]);

        $result = $validator->validate([]);

        $this->assertTrue($result->passes());
        $this->assertEmpty($result->messages()->get('test'));
    }
}

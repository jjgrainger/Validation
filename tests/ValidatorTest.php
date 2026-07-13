<?php

use PHPUnit\Framework\TestCase;
use Validation\Action;
use Validation\Contracts\AssertionContract;
use Validation\Contracts\MessageContract;
use Validation\Validator;

class ValidatorTest extends TestCase
{
    public function test_it_passes_the_correct_value_to_assertions()
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

    public function test_it_does_not_add_messages_when_assertions_pass()
    {
        $assertion = $this->createMock(AssertionContract::class);
        $assertion->expects($this->once())
            ->method('validate')
            ->willReturn(true);

        $validator = Validator::make([
            'test' => [$assertion]
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

        $assertion = $this->createMock(AssertionContract::class);

        $assertion->expects($this->once())
            ->method('validate')
            ->with('value')
            ->willReturn(false);

        $assertion->expects($this->once())
            ->method('onFailure')
            ->willReturn(Action::Fail);

        $assertion->expects($this->once())
            ->method('message')
            ->willReturn($message);

        $validator = Validator::make([
            'test' => [$assertion],
        ]);

        $result = $validator->validate([
            'test' => 'value',
        ]);

        $this->assertFalse($result->passes());
        $this->assertEquals('Invalid test.', $result->messages()->first('test'));
    }

    public function test_it_stops_on_failure_for_assertion()
    {
        $required = $this->createMock(AssertionContract::class);

        $required->expects($this->once())
            ->method('validate')
            ->with(null)
            ->willReturn(false);

        $required->expects($this->once())
            ->method('onFailure')
            ->willReturn(Action::StopRule);

        $bypassed = $this->createMock(AssertionContract::class);

        $bypassed->expects($this->never())
            ->method('validate');

        $validator = Validator::make([
            'test' => [$required, $bypassed],
        ]);

        $result = $validator->validate([]);

        $this->assertTrue($result->fails());
        $this->assertCount(1, $result->messages()->get('test'));
    }

    public function test_it_skips_on_failure_for_assertion()
    {
        $optional = $this->createMock(AssertionContract::class);

        $optional->expects($this->once())
            ->method('validate')
            ->with(null)
            ->willReturn(false);

        $optional->expects($this->once())
            ->method('onFailure')
            ->willReturn(Action::SkipRule);

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

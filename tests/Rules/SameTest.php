<?php

use PHPUnit\Framework\TestCase;
use Validation\Contracts\InputContract;
use Validation\Exceptions\InvalidRuleException;
use Validation\Rules\Same;
use Validation\Rules\Signals\NeedsInput;

class SameTest extends TestCase
{
    public function test_it_passes_value_that_matches(): void
    {
        $rule = new Same;
        $rule->setParameters(['other']);

        $input = $this->createMock(InputContract::class);

        $input->expects($this->once())
            ->method('get')
            ->with('other')
            ->willReturn('value');

        $rule->setInput($input);

        $this->assertTrue($rule->validate('value'));
    }

    public function test_it_fails_value_that_does_not_match(): void
    {
        $rule = new Same;
        $rule->setParameters(['other']);

        $input = $this->createMock(InputContract::class);

        $input->expects($this->once())
            ->method('get')
            ->with('other')
            ->willReturn('fails');

        $rule->setInput($input);

        $this->assertFalse($rule->validate('value'));
    }

    public function test_it_has_needs_input_signal(): void
    {
        $rule = new Same;
        $rule->setParameters(['other']);

        $this->assertInstanceOf(NeedsInput::class, $rule);
    }

    public function test_it_throws_exception_for_missing_parameters(): void
    {
        $this->expectException(InvalidRuleException::class);

        $rule = new Same;
        $rule->setParameters([]);
    }

    public function test_message_contains_parameters(): void
    {
        $rule = new Same;
        $rule->setParameters(['other']);

        $message = $rule->message();

        $this->assertSame(
            [
                ':other' => 'other',
            ],
            $message->bindings()
        );

        $this->assertSame(
            ':attribute must be the same as :other.',
            $message->template()
        );
    }
}

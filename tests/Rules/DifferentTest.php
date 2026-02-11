<?php

use PHPUnit\Framework\TestCase;
use Validation\Contracts\InputContract;
use Validation\Exceptions\InvalidRuleException;
use Validation\Rules\Different;
use Validation\Rules\Signals\NeedsInput;

class DifferentTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $rule = new Different;
        $rule->setParameters(['other']);

        $input = $this->createMock(InputContract::class);

        $input->expects($this->once())
            ->method('get')
            ->with('other')
            ->willReturn('passes');

        $rule->setInput($input);

        $this->assertTrue($rule->validate('value'));
    }

    public function test_it_fails_invalid_value(): void
    {
        $rule = new Different;
        $rule->setParameters(['other']);

        $input = $this->createMock(InputContract::class);

        $input->expects($this->once())
            ->method('get')
            ->with('other')
            ->willReturn('value');

        $rule->setInput($input);

        $this->assertFalse($rule->validate('value'));
    }

    public function test_it_has_needs_input_signal(): void
    {
        $rule = new Different;

        $this->assertInstanceOf(NeedsInput::class, $rule);
    }

    public function test_it_throws_exception_for_missing_parameters(): void
    {
        $this->expectException(InvalidRuleException::class);

        $rule = new Different;
        $rule->setParameters([]);
    }

    public function test_message_contains_parameters(): void
    {
        $rule = new Different;
        $rule->setParameters(['other']);

        $message = $rule->message();

        $this->assertSame(
            [
                ':other' => 'other',
            ],
            $message->bindings()
        );

        $this->assertSame(
            ':attribute must not be the same as :other.',
            $message->template()
        );
    }
}

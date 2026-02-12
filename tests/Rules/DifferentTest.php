<?php

use PHPUnit\Framework\TestCase;
use Validation\Contracts\InputContract;
use Validation\Exceptions\InvalidRuleException;
use Validation\Rules\Different;
use Validation\Rules\Signals\RequiresInput;

class DifferentTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $rule = new Different('other');

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
        $rule = new Different('other');

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
        $rule = new Different('other');

        $this->assertInstanceOf(RequiresInput::class, $rule);
    }

    public function test_message_contains_parameters(): void
    {
        $rule = new Different('other');

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

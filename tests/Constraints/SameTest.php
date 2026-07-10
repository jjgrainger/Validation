<?php

use PHPUnit\Framework\TestCase;
use Validation\Contracts\InputContract;
use Validation\Exceptions\InvalidConstraintException;
use Validation\Constraints\Same;
use Validation\Constraints\Signals\RequiresInput;
use Validation\Contracts\AttributeContract;

class SameTest extends TestCase
{
    public function test_it_passes_value_that_matches(): void
    {
        $rule = new Same('other');

        $attribute = $this->createMock(AttributeContract::class);

        $attribute->expects($this->once())
            ->method('value')
            ->willReturn('value');

        $input = $this->createMock(InputContract::class);

        $input->expects($this->once())
            ->method('attribute')
            ->with('other')
            ->willReturn($attribute);

        $rule->prepare($attribute, $input);

        $this->assertTrue($rule->validate('value'));
    }

    public function test_it_fails_value_that_does_not_match(): void
    {
        $rule = new Same('other');

        $attribute = $this->createMock(AttributeContract::class);

        $attribute->expects($this->once())
            ->method('value')
            ->willReturn('fails');

        $input = $this->createMock(InputContract::class);

        $input->expects($this->once())
            ->method('attribute')
            ->with('other')
            ->willReturn($attribute);

        $rule->prepare($attribute, $input);

        $this->assertFalse($rule->validate('value'));
    }

    public function test_message_contains_parameters(): void
    {
        $rule = new Same('other');

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

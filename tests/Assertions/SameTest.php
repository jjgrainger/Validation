<?php

use PHPUnit\Framework\TestCase;
use Validation\Contracts\InputContract;
use Validation\Assertions\Same;
use Validation\Contracts\AttributeContract;

class SameTest extends TestCase
{
    public function test_it_passes_value_that_matches(): void
    {
        $assertion = new Same('other');

        $attribute = $this->createMock(AttributeContract::class);

        $attribute->expects($this->once())
            ->method('value')
            ->willReturn('value');

        $input = $this->createMock(InputContract::class);

        $input->expects($this->once())
            ->method('attribute')
            ->with('other')
            ->willReturn($attribute);

        $assertion->prepare($attribute, $input);

        $this->assertTrue($assertion->validate('value'));
    }

    public function test_it_fails_value_that_does_not_match(): void
    {
        $assertion = new Same('other');

        $attribute = $this->createMock(AttributeContract::class);

        $attribute->expects($this->once())
            ->method('value')
            ->willReturn('fails');

        $input = $this->createMock(InputContract::class);

        $input->expects($this->once())
            ->method('attribute')
            ->with('other')
            ->willReturn($attribute);

        $assertion->prepare($attribute, $input);

        $this->assertFalse($assertion->validate('value'));
    }

    public function test_message_contains_parameters(): void
    {
        $assertion = new Same('other');

        $message = $assertion->message();

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

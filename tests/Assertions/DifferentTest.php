<?php

use PHPUnit\Framework\TestCase;
use Validation\Contracts\InputContract;
use Validation\Assertions\Different;
use Validation\Contracts\AttributeContract;

class DifferentTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $assertion = new Different('other');

        $attribute = $this->createMock(AttributeContract::class);

        $attribute->expects($this->once())
            ->method('value')
            ->willReturn('different');

        $input = $this->createMock(InputContract::class);

        $input->expects($this->once())
            ->method('attribute')
            ->with('other')
            ->willReturn($attribute);

        $assertion->prepare($attribute, $input);

        $this->assertTrue($assertion->validate('value'));
    }

    public function test_it_fails_invalid_value(): void
    {
        $assertion = new Different('other');

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

        $this->assertFalse($assertion->validate('value'));
    }

    public function test_message_contains_parameters(): void
    {
        $assertion = new Different('other');

        $message = $assertion->message();

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

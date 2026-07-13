<?php

use PHPUnit\Framework\TestCase;
use Validation\Contracts\InputContract;
use Validation\Assertions\Required;
use Validation\Contracts\AttributeContract;

class RequiredTest extends TestCase
{
    public function test_it_fails_with_invalid_value(): void
    {
        $assertion = new Required;

        $input = $this->createStub(InputContract::class);
        $attribute = $this->createMock(AttributeContract::class);

        $attribute->expects($this->once())
            ->method('exists')
            ->willReturn(false);

        $assertion->prepare($attribute, $input);

        $this->assertFalse($assertion->validate(null));
    }

    public function test_it_fails_with_non_existent_attribute(): void
    {
        $assertion = new Required;
        $input = $this->createStub(InputContract::class);
        $attribute = $this->createMock(AttributeContract::class);

        $attribute->expects($this->once())
            ->method('exists')
            ->willReturn(false);

        $assertion->prepare($attribute, $input);

        $this->assertFalse($assertion->validate(null));
    }

    public function test_it_passes_non_empty_value(): void
    {
        $assertion = new Required;
        $input = $this->createStub(InputContract::class);
        $attribute = $this->createStub(AttributeContract::class);

        $attribute->method('exists')
            ->willReturn(true);

        $assertion->prepare($attribute, $input);

        $this->assertTrue($assertion->validate('value'));
        $this->assertTrue($assertion->validate(1));
        $this->assertTrue($assertion->validate(1.234));
        $this->assertTrue($assertion->validate(true));
        $this->assertTrue($assertion->validate(['value']));
    }

    public function test_it_has_a_message(): void
    {
        $assertion = new Required();

        $message = $assertion->message();

        $this->assertSame(
            ':attribute is required.',
            $message->template()
        );
    }
}

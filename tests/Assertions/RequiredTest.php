<?php

use PHPUnit\Framework\TestCase;
use Validation\Contracts\InputContract;
use Validation\Assertions\Required;
use Validation\Assertions\Signals\StopsOnFailure;
use Validation\Contracts\AttributeContract;

class RequiredTest extends TestCase
{
    public function test_it_fails_with_invalid_value(): void
    {
        $rule = new Required;

        $input = $this->createStub(InputContract::class);
        $attribute = $this->createMock(AttributeContract::class);

        $attribute->expects($this->once())
            ->method('exists')
            ->willReturn(false);

        $rule->prepare($attribute, $input);

        $this->assertFalse($rule->validate(null));
    }

    public function test_it_fails_with_non_existent_attribute(): void
    {
        $rule = new Required;
        $input = $this->createStub(InputContract::class);
        $attribute = $this->createMock(AttributeContract::class);

        $attribute->expects($this->once())
            ->method('exists')
            ->willReturn(false);

        $rule->prepare($attribute, $input);

        $this->assertFalse($rule->validate(null));
    }

    public function test_it_passes_non_empty_value(): void
    {
        $rule = new Required;
        $input = $this->createStub(InputContract::class);
        $attribute = $this->createStub(AttributeContract::class);

        $attribute->method('exists')
            ->willReturn(true);

        $rule->prepare($attribute, $input);

        $this->assertTrue($rule->validate('value'));
        $this->assertTrue($rule->validate(1));
        $this->assertTrue($rule->validate(1.234));
        $this->assertTrue($rule->validate(true));
        $this->assertTrue($rule->validate(['value']));
    }

    public function test_it_has_stop_signal(): void
    {
        $rule = new Required();

        $this->assertInstanceOf(StopsOnFailure::class, $rule);
    }

    public function test_it_has_a_message(): void
    {
        $rule = new Required();

        $message = $rule->message();

        $this->assertSame(
            ':attribute is required.',
            $message->template()
        );
    }
}

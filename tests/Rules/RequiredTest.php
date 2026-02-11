<?php

use PHPUnit\Framework\TestCase;
use Validation\Contracts\InputContract;
use Validation\Rules\Required;
use Validation\Rules\Signals\StopsOnFailure;

class RequiredTest extends TestCase
{
    public function test_it_fails_with_invalid_value(): void
    {
        $rule = new Required;
        $rule->setAttribute('required');

        $input = $this->createMock(InputContract::class);

        $input->expects($this->once())
            ->method('exists')
            ->with('required')
            ->willReturn(true);

        $rule->setInput($input);

        $this->assertFalse($rule->validate(null));
    }

    public function test_it_fails_with_non_existent_attribute(): void
    {
        $rule = new Required;
        $rule->setAttribute('required');

        $input = $this->createMock(InputContract::class);

        $input->expects($this->once())
            ->method('exists')
            ->with('required')
            ->willReturn(false);

        $rule->setInput($input);

        $this->assertFalse($rule->validate(null));
    }

    public function test_it_passes_non_empty_value(): void
    {
        $rule = new Required;
        $rule->setAttribute('required');

        $input = $this->createStub(InputContract::class);

        $input->method('exists')
            ->with('required')
            ->willReturn(true);

        $rule->setInput($input);

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

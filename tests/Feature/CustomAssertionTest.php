<?php

use PHPUnit\Framework\TestCase;
use Tests\Fixtures\ExtendedAssertion;
use Validation\Action;
use Tests\Fixtures\SimpleAssertion;

class CustomAssertionTest extends TestCase
{
    public function test_it_provides_default_name_for_custom_assertion(): void
    {
        $custom = new SimpleAssertion;

        $this->assertSame('simpleAssertion', $custom->name());
    }

    public function test_it_provides_default_message_for_custom_assertion(): void
    {
        $custom = new SimpleAssertion;

        $this->assertSame('Invalid :attribute.', $custom->message()->template());
    }

    public function test_it_provides_default_failure_action_for_custom_assertion(): void
    {
        $custom = new SimpleAssertion;

        $this->assertSame(Action::Fail, $custom->onFailure());
    }

    public function test_it_allows_custom_assertion_defaults_to_be_overridden(): void
    {
        $assertion = new ExtendedAssertion(['valid']);

        $this->assertSame('extended', $assertion->name());

        $this->assertSame(
            'Extended assertion failed for :attribute.',
            $assertion->message()->template()
        );

        $this->assertSame(
            Action::StopRule,
            $assertion->onFailure()
        );
    }
}

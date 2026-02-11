<?php

use PHPUnit\Framework\TestCase;
use Validation\Rules\Url;

class UrlTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $rule = new Url;

        $this->assertTrue($rule->validate('http://example.com'));
        $this->assertTrue($rule->validate('https://example.com/path/to/document'));
    }

    public function test_it_fails_invalid_value(): void
    {
        $rule = new Url;

        $this->assertFalse($rule->validate(0));
        $this->assertFalse($rule->validate('not an url'));
        $this->assertFalse($rule->validate('invalid@example'));
        $this->assertFalse($rule->validate('example.test'));
    }

    public function test_it_has_messaage(): void
    {
        $rule = new Url;

        $message = $rule->message();

        $this->assertSame(
            ':attribute must be a valid url.',
            $message->template()
        );
    }
}

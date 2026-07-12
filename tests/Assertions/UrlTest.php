<?php

use PHPUnit\Framework\TestCase;
use Validation\Assertions\Url;

class UrlTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $assertion = new Url;

        $this->assertTrue($assertion->validate('http://example.com'));
        $this->assertTrue($assertion->validate('https://example.com/path/to/document'));
    }

    public function test_it_fails_invalid_value(): void
    {
        $assertion = new Url;

        $this->assertFalse($assertion->validate(0));
        $this->assertFalse($assertion->validate('not an url'));
        $this->assertFalse($assertion->validate('invalid@example'));
        $this->assertFalse($assertion->validate('example.test'));
    }

    public function test_it_has_messaage(): void
    {
        $assertion = new Url;

        $message = $assertion->message();

        $this->assertSame(
            ':attribute must be a valid url.',
            $message->template()
        );
    }
}

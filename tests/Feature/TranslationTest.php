<?php

use PHPUnit\Framework\TestCase;
use Validation\Contracts\TranslatorContract;
use Validation\Validator;

class TranslationTest extends TestCase
{
    public function test_default_translator_returns_original_message()
    {
        $validator = Validator::make([
            'name' => 'required',
        ]);

        $result = $validator->validate([]);

        $this->assertEquals('name is required.', $result->messages()->first('name'));
    }

    public function test_configured_translator_is_used_and_returned_message_formatted_correctly()
    {
        $translator = $this->createMock(TranslatorContract::class);

        $translator->expects($this->once())
            ->method('translate')
            ->with(':attribute is required.')
            ->willReturn('[TRANSLATED]: :attribute is required.');

        $validator = Validator::make(
            [
                'name' => 'required',
            ],
            [
                'translator' => $translator,
            ]
        );

        $result = $validator->validate([]);

        $this->assertEquals('[TRANSLATED]: name is required.', $result->messages()->first('name'));
    }
}

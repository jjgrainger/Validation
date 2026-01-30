<?php

namespace Validation;

use Validation\Contracts\TranslatorContract;

class Translator implements TranslatorContract
{
    public function translate(string $text): string
    {
        return $text;
    }
}

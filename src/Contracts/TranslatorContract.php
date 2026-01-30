<?php

namespace Validation\Contracts;

interface TranslatorContract
{
    public function translate(string $text): string;
}

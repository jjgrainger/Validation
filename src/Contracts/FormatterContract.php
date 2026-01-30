<?php

namespace Validation\Contracts;

interface FormatterContract
{
    public function format(MessageContract $message, string $key, string $attribute, mixed $value): string;
}

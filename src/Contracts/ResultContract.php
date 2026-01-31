<?php

namespace Validation\Contracts;

interface ResultContract
{
    public function add(string $attribute, string $message): void;
}

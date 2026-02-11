<?php

namespace Validation\Rules\Signals;

interface RequiresAttribute
{
    public function setAttribute(string $attribute): void;
}

<?php

namespace Validation\Assertions\Signals;

interface RequiresAttribute
{
    public function setAttribute(string $attribute): void;
}

<?php

namespace Validation\Constraints\Signals;

interface RequiresAttribute
{
    public function setAttribute(string $attribute): void;
}

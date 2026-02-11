<?php

namespace Validation\Rules\Traits;

trait WithAttribute
{
    protected string $attribute;

    public function setAttribute(string $attribute): void
    {
        $this->attribute = $attribute;
    }
}

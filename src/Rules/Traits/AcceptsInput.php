<?php

namespace Validation\Rules\Traits;

use Validation\Contracts\InputContract;

trait AcceptsInput
{
    protected InputContract $input;

    public function setInput(InputContract $input): void
    {
        $this->input = $input;
    }
}

<?php

namespace Validation\Rules\Traits;

use Validation\Contracts\InputContract;

trait WithInput
{
    protected InputContract $input;

    public function setInput(InputContract $input): void
    {
        $this->input = $input;
    }
}

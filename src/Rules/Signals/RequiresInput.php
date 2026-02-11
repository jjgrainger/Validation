<?php

namespace Validation\Rules\Signals;

use Validation\Contracts\InputContract;

interface RequiresInput
{
    public function setInput(InputContract $input): void;
}

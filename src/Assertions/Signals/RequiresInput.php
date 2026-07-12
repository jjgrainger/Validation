<?php

namespace Validation\Assertions\Signals;

use Validation\Contracts\InputContract;

interface RequiresInput
{
    public function setInput(InputContract $input): void;
}

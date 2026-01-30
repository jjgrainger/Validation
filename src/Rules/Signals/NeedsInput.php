<?php

namespace Validation\Rules\Signals;

use Validation\Contracts\InputContract;

interface NeedsInput
{
    public function setInput(InputContract $input): void;
}

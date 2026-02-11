<?php

namespace Validation\Rules\Signals;

interface RequiresParameters
{
    public function setParameters(array $parameters): void;
}

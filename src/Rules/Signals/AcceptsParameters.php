<?php

namespace Validation\Rules\Signals;

interface AcceptsParameters
{
    public function setParameters(array $parameters): void;
}

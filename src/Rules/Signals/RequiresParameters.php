<?php

namespace Validation\Rules\Signals;

interface RequiresParameters
{
    /**
     * Set parameters
     *
     * @param mixed[] $parameters
     * @return void
     */
    public function setParameters(array $parameters): void;
}

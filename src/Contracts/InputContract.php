<?php

namespace Validation\Contracts;

interface InputContract
{
    public function get(string $key): mixed;
}

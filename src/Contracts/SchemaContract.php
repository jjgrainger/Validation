<?php

namespace Validation\Contracts;

use Validation\Contracts\RuleContract;

interface SchemaContract
{
    /**
     * Schema Rules.
     *
     * @return RuleContract[]
     */
    public function rules(): array;
}

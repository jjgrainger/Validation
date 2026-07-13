<?php

namespace Validation\Contracts;

use Validation\Action;

interface PolicyContract
{
    public function onFailure(Action $action): Action;
}

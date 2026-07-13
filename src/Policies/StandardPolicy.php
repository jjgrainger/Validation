<?php

namespace Validation\Policies;

use Validation\Action;
use Validation\Contracts\PolicyContract;

class StandardPolicy implements PolicyContract
{
    public function onFailure(Action $action): Action
    {
        return $action;
    }
}

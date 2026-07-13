<?php

namespace Validation\Policies;

use Validation\Action;
use Validation\Contracts\PolicyContract;

class FailFastPolicy implements PolicyContract
{
    public function onFailure(Action $action): Action
    {
        if ($action === Action::SkipRule) {
            return $action;
        }

        return Action::StopValidation;
    }
}

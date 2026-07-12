<?php

namespace Validation;

enum Failure
{
    /**
     * Record the failure and continue validating.
     */
    case Fail;

    /**
     * Ignore the failure and stop validating the current rule.
     */
    case SkipRule;

    /**
     * Record the failure and stop validating the current rule.
     */
    case StopRule;

    /**
     * Record the failure and stop validation entirely.
     */
    case StopValidation;
}

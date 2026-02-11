<?php

namespace Validation\Providers;

use Validation\Contracts\ProviderContract;
use Validation\Contracts\RegistryContract;

class ConstraintRulesProvider implements ProviderContract
{
    public function register(RegistryContract $registry): void
    {
        $registry->add('accepted', function () {
            return new \Validation\Rules\Accepted();
        });

        $registry->add('between', function () {
            return new \Validation\Rules\Between();
        });

        $registry->add('email', function () {
            return new \Validation\Rules\Email();
        });

        $registry->add('in', function () {
            return new \Validation\Rules\In();
        });

        $registry->add('max', function () {
            return new \Validation\Rules\Max();
        });

        $registry->add('min', function ($min) {
            return new \Validation\Rules\Min();
        });

        $registry->add('notin', function () {
            return new \Validation\Rules\In();
        });

        $registry->add('url', function () {
            return new \Validation\Rules\Url();
        });
    }
}

<?php

namespace Validation\Providers;

use Validation\Contracts\ProviderContract;
use Validation\Contracts\RegistryContract;

class PresenceRulesProvider implements ProviderContract
{
    public function register(RegistryContract $registry): void
    {
        $registry->add('optional', function () {
            return new \Validation\Rules\Optional();
        });

        $registry->add('required', function () {
            return new \Validation\Rules\Required();
        });
    }
}

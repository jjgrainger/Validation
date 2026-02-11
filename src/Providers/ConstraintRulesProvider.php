<?php

namespace Validation\Providers;

use Validation\Contracts\ProviderContract;
use Validation\Contracts\RegistryContract;

class ConstraintRulesProvider implements ProviderContract
{
    public function register(RegistryContract $registry): void
    {
        $registry->add('between', function ($min, $max) {
            return new \Validation\Rules\Between($min, $max);
        });

        $registry->add('email', function () {
            return new \Validation\Rules\Email();
        });

        $registry->add('max', function ($max) {
            return new \Validation\Rules\Max($max);
        });

        $registry->add('min', function ($min) {
            return new \Validation\Rules\Min($min);
        });
    }
}

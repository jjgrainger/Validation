<?php

namespace Validation\Providers;

use Validation\Contracts\ProviderContract;
use Validation\Contracts\RegistryContract;

class TypeRulesProvider implements ProviderContract
{
    public function register(RegistryContract $registry): void
    {
        $registry->add('array', function () {
            return new \Validation\Rules\ArrayType();
        });

        $registry->add('boolean', function () {
            return new \Validation\Rules\Boolean();
        });

        $registry->add('number', function () {
            return new \Validation\Rules\Number();
        });

        $registry->add('string', function () {
            return new \Validation\Rules\StringType();
        });
    }
}

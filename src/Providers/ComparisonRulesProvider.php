<?php

namespace Validation\Providers;

use Validation\Contracts\ProviderContract;
use Validation\Contracts\RegistryContract;

class ComparisonRulesProvider implements ProviderContract
{
    public function register(RegistryContract $registry): void
    {

        $registry->add('different', function ($other) {
            return new \Validation\Rules\Different($other);
        });

        $registry->add('same', function ($other) {
            return new \Validation\Rules\Same($other);
        });
    }
}

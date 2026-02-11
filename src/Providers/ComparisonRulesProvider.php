<?php

namespace Validation\Providers;

use Validation\Contracts\ProviderContract;
use Validation\Contracts\RegistryContract;

class ComparisonRulesProvider implements ProviderContract
{
    public function register(RegistryContract $registry): void
    {

        $registry->add('different', function () {
            return new \Validation\Rules\Different();
        });

        $registry->add('same', function () {
            return new \Validation\Rules\Same();
        });
    }
}

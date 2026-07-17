<?php

namespace Tests\Fixtures;

use Validation\Contracts\ProviderContract;
use Validation\Contracts\RegistryContract;

class CustomProvider implements ProviderContract
{
    public function register(RegistryContract $registry): void
    {
        $registry->add('simpleAssertion', SimpleAssertion::class);

        $registry->bind('extended', function(...$args) {
            return new ExtendedAssertion([...$args]);
        });
    }
}

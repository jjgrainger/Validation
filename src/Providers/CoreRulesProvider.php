<?php

namespace Validation\Providers;

use Validation\Contracts\ProviderContract;
use Validation\Contracts\RegistryContract;

class CoreRulesProvider implements ProviderContract
{
    public function register(RegistryContract $registry): void
    {
        $registry->add('array', fn () => new \Validation\Rules\ArrayType());
        $registry->add('between', fn ($min, $max) => new \Validation\Rules\Between($min, $max));
        $registry->add('boolean', fn () => new \Validation\Rules\Boolean());
        $registry->add('email', fn () => new \Validation\Rules\Email());
        $registry->add('number', fn () => new \Validation\Rules\Number());
        $registry->add('optional', fn () => new \Validation\Rules\Optional());
        $registry->add('required', fn () => new \Validation\Rules\Required());
        $registry->add('same', fn ($other) => new \Validation\Rules\Same($other));
        $registry->add('string', fn () => new \Validation\Rules\StringType());
    }
}

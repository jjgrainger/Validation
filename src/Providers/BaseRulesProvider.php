<?php

namespace Validation\Providers;

use Validation\Contracts\ProviderContract;
use Validation\Contracts\RegistryContract;

class BaseRulesProvider implements ProviderContract
{
    private const RULES = [
        \Validation\Rules\Accepted::class,
        \Validation\Rules\ArrayType::class,
        \Validation\Rules\Between::class,
        \Validation\Rules\Boolean::class,
        \Validation\Rules\Different::class,
        \Validation\Rules\Email::class,
        \Validation\Rules\In::class,
        \Validation\Rules\Length::class,
        \Validation\Rules\Max::class,
        \Validation\Rules\Min::class,
        \Validation\Rules\NotIn::class,
        \Validation\Rules\Number::class,
        \Validation\Rules\Optional::class,
        \Validation\Rules\Required::class,
        \Validation\Rules\Same::class,
        \Validation\Rules\StringType::class,
        \Validation\Rules\Url::class,
    ];

    public function register(RegistryContract $registry): void
    {
        foreach (self::RULES as $rule) {
            $registry->add($rule);
        }
    }
}

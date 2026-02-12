<?php

namespace Validation\Providers;

use Validation\Contracts\ProviderContract;
use Validation\Contracts\RegistryContract;

class BaseRulesProvider implements ProviderContract
{
    private const RULES = [
        'accepted' => \Validation\Rules\Accepted::class,
        'array'    => \Validation\Rules\ArrayType::class,
        'between'  => \Validation\Rules\Between::class,
        'boolean'  => \Validation\Rules\Boolean::class,
        'different'=> \Validation\Rules\Different::class,
        'email'    => \Validation\Rules\Email::class,
        'in'       => \Validation\Rules\In::class,
        'length'   => \Validation\Rules\Length::class,
        'max'      => \Validation\Rules\Max::class,
        'min'      => \Validation\Rules\Min::class,
        'not_in'   => \Validation\Rules\NotIn::class,
        'number'   => \Validation\Rules\Number::class,
        'optional' => \Validation\Rules\Optional::class,
        'required' => \Validation\Rules\Required::class,
        'same'     => \Validation\Rules\Same::class,
        'string'   => \Validation\Rules\StringType::class,
        'url'      => \Validation\Rules\Url::class,
    ];

    public function register(RegistryContract $registry): void
    {
        foreach (self::RULES as $name => $class) {
            $registry->add($name, $class);
        }
    }
}

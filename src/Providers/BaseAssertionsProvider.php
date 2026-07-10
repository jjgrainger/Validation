<?php

namespace Validation\Providers;

use Validation\Contracts\ProviderContract;
use Validation\Contracts\RegistryContract;

class BaseAssertionsProvider implements ProviderContract
{
    private const ASSERTIONS = [
        'accepted' => \Validation\Assertions\Accepted::class,
        'array'    => \Validation\Assertions\ArrayType::class,
        'between'  => \Validation\Assertions\Between::class,
        'boolean'  => \Validation\Assertions\Boolean::class,
        'different'=> \Validation\Assertions\Different::class,
        'email'    => \Validation\Assertions\Email::class,
        'in'       => \Validation\Assertions\In::class,
        'length'   => \Validation\Assertions\Length::class,
        'max'      => \Validation\Assertions\Max::class,
        'min'      => \Validation\Assertions\Min::class,
        'not_in'   => \Validation\Assertions\NotIn::class,
        'number'   => \Validation\Assertions\Number::class,
        'optional' => \Validation\Assertions\Optional::class,
        'required' => \Validation\Assertions\Required::class,
        'same'     => \Validation\Assertions\Same::class,
        'string'   => \Validation\Assertions\StringType::class,
        'url'      => \Validation\Assertions\Url::class,
    ];

    public function register(RegistryContract $registry): void
    {
        foreach (self::ASSERTIONS as $name => $class) {
            $registry->add($name, $class);
        }
    }
}

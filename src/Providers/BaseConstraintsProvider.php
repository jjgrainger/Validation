<?php

namespace Validation\Providers;

use Validation\Contracts\ProviderContract;
use Validation\Contracts\RegistryContract;

class BaseConstraintsProvider implements ProviderContract
{
    private const CONSTRAINTS = [
        'accepted' => \Validation\Constraints\Accepted::class,
        'array'    => \Validation\Constraints\ArrayType::class,
        'between'  => \Validation\Constraints\Between::class,
        'boolean'  => \Validation\Constraints\Boolean::class,
        'different'=> \Validation\Constraints\Different::class,
        'email'    => \Validation\Constraints\Email::class,
        'in'       => \Validation\Constraints\In::class,
        'length'   => \Validation\Constraints\Length::class,
        'max'      => \Validation\Constraints\Max::class,
        'min'      => \Validation\Constraints\Min::class,
        'not_in'   => \Validation\Constraints\NotIn::class,
        'number'   => \Validation\Constraints\Number::class,
        'optional' => \Validation\Constraints\Optional::class,
        'required' => \Validation\Constraints\Required::class,
        'same'     => \Validation\Constraints\Same::class,
        'string'   => \Validation\Constraints\StringType::class,
        'url'      => \Validation\Constraints\Url::class,
    ];

    public function register(RegistryContract $registry): void
    {
        foreach (self::CONSTRAINTS as $name => $class) {
            $registry->add($name, $class);
        }
    }
}

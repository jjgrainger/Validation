<?php

namespace Validation\Providers;

use Validation\Contracts\ProviderContract;
use Validation\Contracts\RegistryContract;

class BaseAssertionsProvider implements ProviderContract
{
    private const ASSERTIONS = [
        // Presence
        'optional' => \Validation\Assertions\Optional::class,
        'required' => \Validation\Assertions\Required::class,

        // Type
        'array'    => \Validation\Assertions\ArrayType::class,
        'boolean'  => \Validation\Assertions\Boolean::class,
        'string'   => \Validation\Assertions\StringType::class,
        'number'   => \Validation\Assertions\Number::class,

        // Strings
        'length'   => \Validation\Assertions\Length::class,
        // 'min_length',
        // 'max_length',

        // Numbers
        'max'      => \Validation\Assertions\Max::class,
        'min'      => \Validation\Assertions\Min::class,
        'between'  => \Validation\Assertions\Between::class,

        // Comparison
        'different'=> \Validation\Assertions\Different::class,
        'same'     => \Validation\Assertions\Same::class,

        // Value
        // 'in'       => \Validation\Assertions\In::class,
        // 'not_in'   => \Validation\Assertions\NotIn::class,
        'accepted' => \Validation\Assertions\Accepted::class,

        // Date
        // 'date'
        // 'before'
        // 'after'
        // 'before_or_equal'
        // 'after_or_equal'
        // 'date_between'

        // File
        // 'file'
        // 'file_size'
        // 'file_type'
        // 'image'

        // Format
        'email'    => \Validation\Assertions\Email::class,
        'url'      => \Validation\Assertions\Url::class,
        // 'alpha'
        // 'alpha_dash'
        // 'alpha_numeric'
        // 'regex'
        // 'ip'
    ];

    public function register(RegistryContract $registry): void
    {
        foreach (self::ASSERTIONS as $name => $class) {
            $registry->add($name, $class);
        }

        $registry->bind('in', fn (...$params) => new \Validation\Assertions\In([...$params]));
        $registry->bind('not_in', fn (...$params) => new \Validation\Assertions\NotIn([...$params]));
    }
}

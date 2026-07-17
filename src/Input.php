<?php

namespace Validation;

use InvalidArgumentException;
use Validation\Contracts\AttributeContract;
use Validation\Contracts\InputContract;

class Input implements InputContract
{
    /**
     * Input data.
     *
     * @var array<mixed>
     */
    private array $input;

    /**
     * Constructor.
     *
     * @param mixed[] $input
     */
    public function __construct(array $input)
    {
        $this->input = $input;
    }

    /**
     * Get attributes for a selector.
     *
     * @param string $selector
     * @return AttributeContract[]
     */
    public function attributes(string $selector): array
    {
        $branches = [
            [
                'path' => '',
                'value' => $this->input,
                'exists' => true,
            ],
        ];

        foreach (Selector::make($selector)->parts() as $part) {
            $next = [];

            foreach ($branches as $state) {
                $path = $state['path'];
                $value = $state['value'];
                $exists = $state['exists'];

                if ('*' === $part) {
                    if (!$exists || !is_array($value)) {
                        continue;
                    }

                    foreach ($value as $key => $child) {
                        $next[] = [
                            'path' => ltrim("{$path}.{$key}", '.'),
                            'value' => $child,
                            'exists' => true,
                        ];
                    }

                    continue;
                }

                $childPath = ltrim("{$path}.{$part}", '.');

                if (!$exists || !is_array($value)) {
                    $next[] = [
                        'path' => $childPath,
                        'value' => null,
                        'exists' => false,
                    ];

                    continue;
                }

                $exists = array_key_exists($part, $value);

                $next[] = [
                    'path' => $childPath,
                    'value' => $exists ? $value[$part] : null,
                    'exists' => $exists,
                ];
            }

            $branches = $next;
        }

        return array_map(
            function (array $attribute): AttributeContract {
                return new Attribute(
                    key: $attribute['path'],
                    value: $attribute['value'],
                    exists: $attribute['exists'],
                );
            },
            $branches
        );
    }

    /**
     * Get an attribute for a non-wildcard selector.
     *
     * @param string $selector
     * @return AttributeContract
     */
    public function attribute(string $selector): AttributeContract
    {
        if (Selector::make($selector)->hasWildcard()) {
            throw new InvalidArgumentException(
                'A single attribute cannot be retrieved from a selector containing a wildcard.'
            );
        }

        return $this->attributes($selector)[0] ?? new Attribute(
            key: $selector,
            value: null,
            exists: false,
        );
    }

    /**
     * Return the raw input.
     *
     * @return array<string, mixed>
     */
    public function input(): array
    {
        return $this->input;
    }
}

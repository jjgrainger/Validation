<?php

namespace Validation;

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
     * Resolved values for selectors.
     *
     * @var array<string, mixed>
     */
    private array $values;

    /**
     * Resolved list of which values exist.
     *
     * @var array<string, bool>
     */
    private array $exists;

    /**
     * Constructor.
     *
     * @param mixed[] $input
     */
    public function __construct(array $input)
    {
        $this->input = $input;
        $this->values = [];
        $this->exists = [];
    }

    /**
     * Get a single value by attribute (not selector).
     *
     * @param string $attribute
     * @param mixed $default
     * @return mixed
     */
    public function get(string $attribute, mixed $default = null): mixed
    {
        return $this->values[$attribute] ?? $default;
    }

    /**
     * Return an array of values for a selector.
     *
     * @param string $selector
     * @return array<string, mixed>
     */
    public function values(string $selector): array
    {
        $selector = Selector::make($selector);
        $values = [];

        foreach ($this->values as $key => $value) {
            if ($selector->matches($key)) {
                $values[$key] = $value;
            }
        }

        return $values;
    }

    /**
     * Check if the attribute existed in the input data.
     *
     * @param string $attribute
     * @return boolean
     */
    public function exists(string $attribute): bool
    {
        return $this->exists[$attribute] ?? false;
    }

    /**
     * Evaluate the input based on the validation selectors.
     *
     * @param string[] $selectors
     * @return void
     */
    public function evaluate(array $selectors): void
    {
        foreach ($selectors as $selector) {
            $cursors = [
                [
                    'path' => [],
                    'value' => $this->input,
                    'exists' => true,
                ],
            ];

            foreach (Selector::make($selector)->parts() as $part) {
                $next = [];

                foreach ($cursors as $cursor) {
                    if (!is_array($cursor['value'])) {
                        continue;
                    }

                    if ($part === '*') {
                        foreach ($cursor['value'] as $key => $child) {
                            $next[] = [
                                'path' => [...$cursor['path'], $key],
                                'value' => $child,
                                'exists' => true,
                            ];
                        }

                        continue;
                    }

                    $exists = array_key_exists($part, $cursor['value']);

                    $next[] = [
                        'path'  => [...$cursor['path'], $part],
                        'value' => $exists ? $cursor['value'][$part] : null,
                        'exists' => $exists,
                    ];
                }

                $cursors = $next;
            }

            foreach ($cursors as $cursor) {
                $key = implode('.', $cursor['path']);

                $this->values[$key] = $cursor['value'];
                $this->exists[$key] = $cursor['exists'];
            }
        }
    }
}

<?php

namespace Validation;

use Stringable;
use Validation\Exceptions\InvalidSelectorException;

class Selector implements Stringable
{
    /**
     * The selector string.
     *
     * @var string
     */
    protected string $selector;

    /**
     * Constructor.
     *
     * @param string $selector
     */
    public function __construct(string $selector)
    {
        self::validate($selector);

        $this->selector = self::normalize($selector);
    }

    /**
     * Make selector from string.
     *
     * @param string $selector
     * @return self
     */
    public static function make(string $selector): self
    {
        return new self($selector);
    }

    /**
     * Normalize a selector.
     *
     * @param string $selector
     * @return string
     */
    public static function normalize(string $selector): string
    {
        return trim($selector);
    }

    /**
     * Validate a selector.
     *
     * @param string $selector
     * @return void
     */
    public static function validate(string $selector): void
    {
        $selector = self::normalize($selector);

        if ('' === $selector) {
            throw InvalidSelectorException::empty();
        }

        if (!preg_match('/^[A-Za-z0-9.*]+$/', $selector)) {
            throw InvalidSelectorException::invalidCharacters($selector);
        }

        if (str_starts_with($selector, '*') || str_ends_with($selector, '*')) {
            throw InvalidSelectorException::invalidWildCard($selector);
        }

        if (str_contains($selector, '..') || str_starts_with($selector, '.') || str_ends_with($selector, '.')) {
            throw InvalidSelectorException::emptySegments($selector);
        }
    }

    /**
     * Return the selector parts.
     *
     * @return string[]
     */
    public function parts(): array
    {
        return explode('.', $this->selector);
    }

    /**
     * Check the selector has a wildcard.
     *
     * @return boolean
     */
    public function hasWildcard(): bool
    {
        return str_contains($this->selector, '*');
    }

    /**
     * Check if the selector is nested.
     *
     * @return boolean
     */
    public function isNested(): bool
    {
        return str_contains($this->selector, '.');
    }

    /**
     * Check if a value matches the selector.
     *
     * @param string $value
     * @return boolean
     */
    public function matches(string $value): bool
    {
        $pattern = preg_quote($this->selector, '/');
        $pattern = str_replace('\*', '[^.]+', $pattern);
        $pattern = '/^' . $pattern . '$/';

        return (bool) preg_match($pattern, $value);
    }

    /**
     * Filter a dataset and return a set where keys match the selector.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function filter(array $data): array
    {
        $found = [];

        foreach ($data as $key => $value) {
            if ($this->matches($key)) {
                $found[$key] = $value;
            }
        }

        return $found;
    }

    /**
     * Expand a dataset to concrete attributes and values.
     *
     * @param mixed[] $data
     * @return array<string, mixed>
     */
    public function expand(array $data): array
    {
        $results = ['' => $data];

        foreach ($this->parts() as $segment) {
            $next = [];

            foreach ($results as $path => $value) {
                if (!is_array($value)) {
                    continue;
                }

                if ($segment === '*') {
                    foreach ($value as $key => $child) {
                        $newPath = ltrim($path . '.' . $key, '.');
                        $next[$newPath] = $child;
                    }
                } else {
                    $newPath = ltrim($path . '.' . $segment, '.');
                    $next[$newPath] = $value[$segment] ?? null;
                }
            }

            $results = $next;
        }

        return $results;
    }

    /**
     * Return the selector string.
     *
     * @return string
     */
    public function toString(): string
    {
        return $this->selector;
    }

    /**
     * Convert to a string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}

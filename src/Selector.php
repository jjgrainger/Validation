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

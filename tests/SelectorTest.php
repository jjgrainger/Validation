<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Validation\Exceptions\InvalidSelectorException;
use Validation\Selector;

class SelectorTest extends TestCase
{
    public function test_it_matches_basic_attribute(): void
    {
        $selctor = new Selector('item');

        $this->assertTrue($selctor->matches('item'));
        $this->assertFalse($selctor->matches('item.name'));
        $this->assertFalse($selctor->matches('items.*.name'));
    }

    public function test_it_matches_nested_attribute(): void
    {
        $selctor = new Selector('item.name');

        $this->assertTrue($selctor->matches('item.name'));
        $this->assertFalse($selctor->matches('item'));
        $this->assertFalse($selctor->matches('items.0.name'));
    }

    public function test_it_matches_wildcard_attribute(): void
    {
        $selctor = new Selector('items.*.name');

        $this->assertTrue($selctor->matches('items.0.name'));
        $this->assertTrue($selctor->matches('items.1.name'));
        $this->assertTrue($selctor->matches('items.99.name'));
        $this->assertTrue($selctor->matches('items.999.name'));

        $this->assertFalse($selctor->matches('item.name'));
        $this->assertFalse($selctor->matches('item'));
    }

    public function test_it_matches_nested_wildcard_attribute(): void
    {
        $selctor = new Selector('items.*.tags.*.name');

        $this->assertTrue($selctor->matches('items.0.tags.0.name'));
        $this->assertTrue($selctor->matches('items.10.tags.0.name'));
        $this->assertTrue($selctor->matches('items.999.tags.999.name'));

        $this->assertFalse($selctor->matches('items.0.tags'));
        $this->assertFalse($selctor->matches('item.name'));
        $this->assertFalse($selctor->matches('item'));
    }

    #[DataProvider('invalidSelectors')]
    public function test_it_throws_exception_for_invalid_selectors(string $selector): void
    {
        $this->expectException(InvalidSelectorException::class);

        Selector::validate($selector);
    }

    public static function invalidSelectors(): array
    {
        return [
            'empty' => [''],
            'leading dot' => ['.name'],
            'trailing dot' => ['name.'],
            'double dot' => ['user..email'],
            'invalid wildcard placement' => ['*.name'],
        ];
    }
}

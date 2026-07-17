<?php

use PHPUnit\Framework\TestCase;
use Validation\Validator;

class WildcardValidationTest extends TestCase
{
    public function test_it_can_validate_with_wildcard_selector(): void
    {
        $validator = Validator::make([
            'users.*.name' => 'required|string',
        ]);

        $result = $validator->validate([
            'users' => [
                [],
                ['name' => null],
                ['name' => 100],
                ['name' => 'admin'],
            ]
        ]);

        $this->assertSame('users.0.name is required.', $result->messages()->first('users.0.name'));
        $this->assertSame('users.1.name is required.', $result->messages()->first('users.1.name'));
        $this->assertSame('users.2.name must be a string.', $result->messages()->first('users.2.name'));
        $this->assertNull($result->messages()->first('users.3.name'));
    }

    public function test_it_does_not_validate_when_no_items_match_wildcard_selector(): void
    {
        $validator = Validator::make([
            'users' => 'optional|array',
            'users.*.name' => 'required|string',
        ]);

        $result = $validator->validate([
            'users' => []
        ]);

        $this->assertNull($result->messages()->first('users'));
        $this->assertNull($result->messages()->first('users.0.name'));
    }

    public function test_it_can_match_associative_collection_keys(): void
    {
        $validator = Validator::make([
            'users.*.email' => 'required|email',
        ]);

        $result = $validator->validate([
            'users' => [
                'alice' => ['email' => ''],
                'adam' => ['email' => ''],
            ]
        ]);

        $this->assertSame('users.alice.email is required.', $result->messages()->first('users.alice.email'));
        $this->assertSame('users.adam.email is required.', $result->messages()->first('users.adam.email'));
    }

    public function test_it_can_validate_selectors_with_nested_wildcard(): void
    {
        $validator = Validator::make([
            'posts.*.tags.*.name' => 'required|string',
        ]);

        $result = $validator->validate([
            'posts' => [
                [
                    'title' => 'Post title',
                    'tags' => [
                        ['name' => ''],
                    ]
                ]
            ]
        ]);

        $this->assertSame('posts.0.tags.0.name is required.', $result->messages()->first('posts.0.tags.0.name'));
    }

    public function test_it_does_not_validate_when_nested_wildcard_has_no_matches(): void
    {
        $validator = Validator::make([
            'posts.*.tags.*.name' => 'required|string',
        ]);

        $result = $validator->validate([
            'posts' => [
                [
                    'title' => 'Post title',
                    'tags' => [],
                ],
            ],
        ]);

        $this->assertNull($result->messages()->first('posts.0.tags.0.name'));
    }

    public function test_it_can_validate_selectors_that_start_with_wildcard(): void
    {
        $validator = Validator::make([
            '*.title' => 'required|string',
        ]);

        $result = $validator->validate([
            ['title' => ''],
            ['title' => 'news'],
            ['title' => ''],
        ]);

        $this->assertSame('0.title is required.', $result->messages()->first('0.title'));
        $this->assertNull($result->messages()->first('1.title'));
        $this->assertSame('2.title is required.', $result->messages()->first('2.title'));
    }

    public function test_it_can_validate_selectors_that_end_with_wildcard(): void
    {
        $validator = Validator::make([
            'tags.*' => 'required|string',
        ]);

        $result = $validator->validate([
            'tags' => ['news', '', 'blog'],
        ]);

        $this->assertNull($result->messages()->first('tags.0'));
        $this->assertSame('tags.1 is required.', $result->messages()->first('tags.1'));
        $this->assertNull($result->messages()->first('tags.2'));
    }
}

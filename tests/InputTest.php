<?php

use PHPUnit\Framework\TestCase;
use Validation\Input;

class InputTest extends TestCase
{
    public function test_it_gets_values_from_data_passed(): void
    {
        $data = [
            'test' => 'test data.',
        ];

        $input = new Input($data);

        $input->index(array_keys($data));

        $this->assertSame($data['test'], $input->get('test'));
    }

    public function test_it_gets_with_dot_notated_attributes(): void
    {
        $data = [
            'test' => 'test data.',
            'author' => [
                'name' => 'Admin',
                'email' => 'admin@example.com',
            ]
        ];

        $input = new Input($data);

        $input->index([
            'test',
            'author.name',
            'author.email',
        ]);

        $this->assertSame($data['test'], $input->get('test'));
        $this->assertSame($data['author']['name'], $input->get('author.name'));
        $this->assertSame($data['author']['email'], $input->get('author.email'));
    }

    public function test_it_can_get_values_with_dot_notated_keys(): void
    {
        $data = [
            'title' => 'Post title',
            'author' => [
                'name' => 'Admin',
                'email' => 'admin@example.com',
            ],
        ];

        $input = new Input($data);

        $input->index([
            'title',
            'author.name',
            'author.email',
            'author.avatar',
        ]);

        $this->assertSame(['title' => 'Post title'], $input->values('title'));
        $this->assertSame(['author.name' => 'Admin'], $input->values('author.name'));
        $this->assertSame(['author.email' => 'admin@example.com'], $input->values('author.email'));
    }

    public function test_it_can_get_values_wildcard_notated_keys(): void
    {
        $data = [
            'post' => [
                'title' => 'Post title',
                'author' => [
                    'name' => 'Admin',
                    'email' => 'admin@examaple.com',
                ],
                'related' => [
                    [
                        'title' => 'Related post title 1',
                        'url' => 'https://example.com/related-post-1',
                        'tags' => ['blog', 'news'],
                    ],
                    [
                        'title' => 'Related post title 2',
                        'url' => 'https://example.com/related-post-2',
                        'tags' => ['news', 'featured', 'announcement'],
                    ],
                ]
            ]
        ];

        $input = new Input($data);

        $input->index([
            'post.title',
            'post.author.name',
            'post.related.*.title',
            'post.related.*.tags',
        ]);

        $this->assertSame(
            [
                'post.related.0.title' => 'Related post title 1',
                'post.related.1.title' => 'Related post title 2',
            ],
            $input->values('post.related.*.title')
        );

        $this->assertSame(
            [
                'post.related.0.tags' => ['blog', 'news'],
                'post.related.1.tags' => ['news', 'featured', 'announcement'],
            ],
            $input->values('post.related.*.tags')
        );
    }
}

<?php

use PHPUnit\Framework\TestCase;
use Validation\Validator;

class MessageFormattingTest extends TestCase
{
    public function test_custom_messaages_are_used_for_assertion()
    {
        $validator = Validator::make(
            [
                'name' => 'required|string|min:3',
                'email' => 'required|email',
            ],
            [
                'messages' => [
                    'required' => 'This field is required.'
                ]
            ]
        );

        $result = $validator->validate([]);

        $this->assertEquals('This field is required.', $result->messages()->first('name'));
        $this->assertEquals('This field is required.', $result->messages()->first('email'));
    }

    public function test_custom_messsages_with_attribute_are_used()
    {
        $validator = Validator::make(
            [
                'name' => 'required|string|min:3',
                'email' => 'required|email',
            ],
            [
                'messages' => [
                    'name.required' => 'This field is required.'
                ]
            ]
        );

        $result = $validator->validate([]);

        $this->assertEquals('This field is required.', $result->messages()->first('name'));
        $this->assertEquals('email is required.', $result->messages()->first('email'));
    }

    public function test_placeholders_are_replaced_in_custom_messages()
    {
        $validator = Validator::make(
            [
                'name' => 'required|string|min:3',
                'email' => 'required|email',
            ],
            [
                'messages' => [
                    'name.required' => 'The field :attribute is required.'
                ]
            ]
        );

        $result = $validator->validate([]);

        $this->assertEquals('The field name is required.', $result->messages()->first('name'));
        $this->assertEquals('email is required.', $result->messages()->first('email'));
    }

    public function test_custom_messages_for_nested_selectors_are_used()
    {
        $validator = Validator::make(
            [
                'user.name' => 'required|string|min:3',
            ],
            [
                'messages' => [
                    'user.name.required' => 'Username is required.'
                ]
            ]
        );

        $result = $validator->validate([]);

        $this->assertEquals('Username is required.', $result->messages()->first('user.name'));
    }

    public function test_custom_messages_for_wildcard_selectors_are_used()
    {
        $validator = Validator::make(
            [
                'users.*.name' => 'required|string|min:3',
            ],
            [
                'messages' => [
                    'users.*.name.required' => 'Users must have a name.',
                ]
            ]
        );

        $result = $validator->validate([
            'users' => [
                ['name' => ''],
            ],
        ]);

        $this->assertEquals('Users must have a name.', $result->messages()->first('users.0.name'));
    }

    public function test_custom_messages_are_resolved_by_precedence()
    {
        $validator = Validator::make(
            [
                'name' => 'required|string',
                'users.*.name' => 'required|string|min:3',
            ],
            [
                'messages' => [
                    'users.*.name.required' => 'Users must have a name.',
                    'users.0.name.required' => 'First user must have a name.',
                    'required' => 'This field is required.',
                ]
            ]
        );

        $result = $validator->validate([
            'users' => [
                ['name' => ''],
                ['name' => ''],
            ],
        ]);

        $this->assertEquals('First user must have a name.', $result->messages()->first('users.0.name'));
        $this->assertEquals('Users must have a name.', $result->messages()->first('users.1.name'));
        $this->assertEquals('This field is required.', $result->messages()->first('name'));
    }

    public function test_custom_aliases_for_attributes_are_used()
    {
        $validator = Validator::make(
            [
                'password' => 'required',
                'password_confirm' => 'required',
            ],
            [
                'aliases' => [
                    'password_confirm' => 'Password confirmation'
                ]
            ]
        );

        $result = $validator->validate([]);

        $this->assertEquals('Password confirmation is required.', $result->messages()->first('password_confirm'));
    }

    public function test_aliases_are_applied_to_message_placeholders()
    {
        $validator = Validator::make(
            [
                'user_password' => 'required',
                'user_password_confirm' => 'required|same:user_password',
            ],
            [
                'aliases' => [
                    'user_password' => 'Password',
                    'user_password_confirm' => 'Password confirmation'
                ]
            ]
        );

        $result = $validator->validate([
            'user_password' => 'secret',
            'user_password_confirm' => 'abc',
        ]);

        $this->assertEquals(
            'Password confirmation must be the same as Password.',
            $result->messages()->first('user_password_confirm')
        );
    }

    public function test_aliases_for_wildcard_selectors_are_used()
    {
        $validator = Validator::make(
            [
                'users.*.name' => 'required|string|min:3',
            ],
            [
                'aliases' => [
                    'users.*.name' => 'User name',
                ]
            ]
        );

        $result = $validator->validate([
            'users' => [
                ['name' => ''],
                ['name' => ''],
            ],
        ]);

        $this->assertEquals('User name is required.', $result->messages()->first('users.0.name'));
        $this->assertEquals('User name is required.', $result->messages()->first('users.1.name'));
    }

    public function test_aliases_are_resolved_by_precedence()
    {
        $validator = Validator::make(
            [
                'users.*.name' => 'required|string|min:3',
            ],
            [
                'aliases' => [
                    'users.0.name' => 'First user name',
                    'users.*.name' => 'Users name',
                ]
            ]
        );

        $result = $validator->validate([
            'users' => [
                ['name' => ''],
                ['name' => ''],
            ],
        ]);

        $this->assertEquals('First user name is required.', $result->messages()->first('users.0.name'));
        $this->assertEquals('Users name is required.', $result->messages()->first('users.1.name'));
    }
}

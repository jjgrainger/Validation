<?php

use PHPUnit\Framework\TestCase;
use Validation\Policies\CollectAllPolicy;
use Validation\Policies\FailFastPolicy;
use Validation\Policies\StandardPolicy;
use Validation\Validator;

class PoliciesTest extends TestCase
{
    public function test_standard_policy_preserves_assertion_actions()
    {
        $validator = Validator::make(
            [
                'name' => 'required|string|min:3',
            ],
            [
                'policy' => new StandardPolicy(),
            ]
        );

        $result = $validator->validate([]);

        $this->assertCount(1, $result->messages()->get('name'));
        $this->assertEquals('name is required.', $result->messages()->first('name'));
    }

    public function test_standard_policy_still_respects_skip_rule_action()
    {
        $validator = Validator::make(
            [
                'name' => 'optional|string|min:3',
                'email' => 'required|email',
            ],
            [
                'policy' => new StandardPolicy(),
            ]
        );

        $result = $validator->validate([]);

        $this->assertCount(1, $result->messages()->get('email'));
        $this->assertEquals('email is required.', $result->messages()->first('email'));
        $this->assertEmpty($result->messages()->get('name'));
    }

    public function test_fail_fast_stops_after_the_first_failure()
    {
        $validator = Validator::make(
            [
                'name' => 'required|string|min:3',
                'email' => 'required|email',
            ],
            [
                'policy' => new FailFastPolicy(),
            ]
        );

        $result = $validator->validate([]);

        $this->assertCount(1, $result->messages()->get('name'));
        $this->assertEquals('name is required.', $result->messages()->first('name'));
        $this->assertEmpty($result->messages()->get('email'));
    }

    public function test_fail_fast_still_respects_skip_rule_action()
    {
        $validator = Validator::make(
            [
                'name' => 'optional|string|min:3',
                'email' => 'required|email',
            ],
            [
                'policy' => new FailFastPolicy(),
            ]
        );

        $result = $validator->validate([]);

        $this->assertCount(1, $result->messages()->get('email'));
        $this->assertEquals('email is required.', $result->messages()->first('email'));
        $this->assertEmpty($result->messages()->get('name'));
    }

    public function test_collect_all_continues_after_failures()
    {
        $validator = Validator::make(
            [
                'name' => 'required|string|min:3',
                'email' => 'required|email',
            ],
            [
                'policy' => new CollectAllPolicy(),
            ]
        );

        $result = $validator->validate([]);

        $this->assertEquals([
            'name is required.',
            'name must be a string.',
            'name must be greater than 3.',
        ], $result->messages()->get('name'));

        $this->assertEquals([
            'email is required.',
            'email must be a valid email.',
        ], $result->messages()->get('email'));
    }

    public function test_collect_all_still_respects_skip_rule_action()
    {
        $validator = Validator::make(
            [
                'name' => 'optional|string|min:3',
                'username' => 'required|string|min:3',
                'email' => 'required|email',
            ],
            [
                'policy' => new CollectAllPolicy(),
            ]
        );

        $result = $validator->validate([]);

        $this->assertEquals([
            'username is required.',
            'username must be a string.',
            'username must be greater than 3.',
        ], $result->messages()->get('username'));

        $this->assertEquals([
            'email is required.',
            'email must be a valid email.',
        ], $result->messages()->get('email'));
    }
}

<?php

use PHPUnit\Framework\TestCase;
use Validation\Contracts\RuleContract;
use Validation\Exceptions\InvalidRuleException;
use Validation\Registry;
use Validation\Rule;

class RegistryTest extends TestCase
{
    public function test_it_adds_rule_with_class(): void
    {
        $rule = new class extends Rule {
            public function validate(mixed $value): bool { return true; }
        };

        $registry = new Registry;
        $registry->add('rule', $rule::class);

        $resolved = $registry->resolve('rule', []);

        $this->assertInstanceOf($rule::class, $resolved);
        $this->assertInstanceOf(RuleContract::class, $resolved);
    }

    public function test_it_adds_rule_with_factory(): void
    {
        $rule = new class extends Rule {
            public function validate(mixed $value): bool { return true; }
        };

        $class = $rule::class;

        $registry = new Registry;
        $registry->bind('rule', fn() => new $class);

        $resolved = $registry->resolve('rule', []);

        $this->assertInstanceOf($rule::class, $resolved);
    }

    public function test_it_passes_parameters_to_rule_constructor(): void
    {
        $registry = new Registry;
        $registry->bind('rule', fn($first, $second) => new class($first, $second) extends Rule {
            public array $params;
            public function __construct($first, $second) {
                $this->params = [$first, $second];
            }
            public function validate(mixed $value): bool { return true; }
        });

        $params = ['first', 'second'];
        $resolved = $registry->resolve('rule', $params);

        $this->assertSame($resolved->params, $params);
    }

    public function test_it_throws_exception_for_invalid_class(): void
    {
        $this->expectException(InvalidRuleException::class);

        $registry = new Registry;
        $registry->add('rule', stdClass::class);
    }
}

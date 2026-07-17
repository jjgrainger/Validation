<?php

use PHPUnit\Framework\TestCase;
use Validation\Contracts\AssertionContract;
use Validation\Exceptions\InvalidAssertionException;
use Validation\Registry;
use Validation\Assertion;

class RegistryTest extends TestCase
{
    public function test_it_adds_assertion_with_class(): void
    {
        $assertion = new class extends Assertion {
            public function validate(mixed $value): bool { return true; }
        };

        $registry = new Registry;
        $registry->add('assertion', $assertion::class);

        $resolved = $registry->resolve('assertion', []);

        $this->assertInstanceOf($assertion::class, $resolved);
        $this->assertInstanceOf(AssertionContract::class, $resolved);
    }

    public function test_it_binds_assertion_with_factory(): void
    {
        $assertion = new class extends Assertion {
            public function validate(mixed $value): bool { return true; }
        };

        $class = $assertion::class;

        $registry = new Registry;
        $registry->bind('assertion', fn() => new $class);

        $resolved = $registry->resolve('assertion', []);

        $this->assertInstanceOf($assertion::class, $resolved);
    }

    public function test_it_passes_parameters_to_assertion_constructor(): void
    {
        $assertion = new class('one', 'two') extends Assertion {
            public array $params;
            public function __construct(string $one, string $two) {
                $this->params = [$one, $two];
            }
            public function validate(mixed $value): bool { return true; }
        };

        $registry = new Registry;
        $registry->add('assertion', $assertion::class);

        $resolved = $registry->resolve('assertion', ['first', 'second']);

        $this->assertSame(['first', 'second'], $resolved->params);
    }

    public function test_it_passes_parameters_to_assertion_constructor_using_factory(): void
    {
        $registry = new Registry;
        $registry->bind('assertion', fn($one, $two) => new class([$one, $two]) extends Assertion {
            public array $params;
            public function __construct(array $params) {
                $this->params = $params;
            }
            public function validate(mixed $value): bool { return true; }
        });

        $resolved = $registry->resolve('assertion', ['first', 'second']);

        $this->assertSame(['first', 'second'], $resolved->params);
    }

    public function test_it_throws_exception_for_invalid_class(): void
    {
        $this->expectException(InvalidAssertionException::class);

        $registry = new Registry;
        $registry->add('assertion', stdClass::class);
    }

    public function test_it_throws_for_unknown_name()
    {
        $this->expectException(InvalidAssertionException::class);

        $registry = new Registry;
        $registry->resolve('unknown');
    }
}

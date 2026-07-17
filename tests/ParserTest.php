<?php

use PHPUnit\Framework\TestCase;
use Validation\Assertion;
use Validation\Contracts\RegistryContract;
use Validation\Exceptions\InvalidAssertionException;
use Validation\Exceptions\InvalidAssertionListException;
use Validation\Parser;

class ParserTest extends TestCase
{
    public function test_it_parses_single_string_assertion()
    {
        $rules = [
            'test' => 'assertion',
        ];

        $assertion = $this->createStub(Assertion::class);

        $registry = $this->createMock(RegistryContract::class);

        $registry->expects($this->once())
            ->method('resolve')
            ->with('assertion')
            ->willReturn($assertion);

        $parser = new Parser($registry);

        $schema = $parser->parse($rules);
        $rule = $schema->rules()[0];

        $this->assertEquals('test', $rule->selector());
        $this->assertCount(1, $rule->assertions());
        $this->assertSame($assertion, $rule->assertions()[0]);
    }

    public function test_it_parses_pipe_delimited_assertions()
    {
        $rules = [
            'test' => 'required|string',
        ];

        $required = $this->createStub(Assertion::class);
        $string = $this->createStub(Assertion::class);

        $registry = $this->createMock(RegistryContract::class);

        $registry->expects($this->exactly(2))
            ->method('resolve')
            ->willReturnMap([
                ['required', [], $required],
                ['string', [], $string],
            ]);

        $parser = new Parser($registry);

        $schema = $parser->parse($rules);

        $rule = $schema->rules()[0];

        $this->assertEquals('test', $rule->selector());
        $this->assertCount(2, $rule->assertions());
        $this->assertSame($required, $rule->assertions()[0]);
        $this->assertSame($string, $rule->assertions()[1]);
    }

    public function test_it_parses_assertion_parameters()
    {
        $rules = [
            'test' => 'between:1,3',
        ];

        $assertion = $this->createStub(Assertion::class);

        $registry = $this->createMock(RegistryContract::class);

        $registry->expects($this->once())
            ->method('resolve')
            ->with('between', [1, 3])
            ->willReturn($assertion);

        $parser = new Parser($registry);

        $schema = $parser->parse($rules);
        $rule = $schema->rules()[0];

        $this->assertEquals('test', $rule->selector());
        $this->assertCount(1, $rule->assertions());
        $this->assertSame($assertion, $rule->assertions()[0]);
    }

    public function test_it_parses_array_of_strings()
    {
        $rules = [
            'test' => ['required', 'string'],
        ];

        $required = $this->createStub(Assertion::class);
        $string = $this->createStub(Assertion::class);

        $registry = $this->createMock(RegistryContract::class);

        $registry->expects($this->exactly(2))
            ->method('resolve')
            ->willReturnMap([
                ['required', [], $required],
                ['string', [], $string],
            ]);

        $parser = new Parser($registry);

        $schema = $parser->parse($rules);
        $rule = $schema->rules()[0];

        $this->assertEquals('test', $rule->selector());
        $this->assertCount(2, $rule->assertions());
        $this->assertSame($required, $rule->assertions()[0]);
        $this->assertSame($string, $rule->assertions()[1]);
    }

    public function test_it_parses_array_of_assertion_objects()
    {
        $required = $this->createStub(Assertion::class);
        $string = $this->createStub(Assertion::class);

        $rules = [
            'test' => [$required, $string],
        ];

        $registry = $this->createStub(RegistryContract::class);

        $parser = new Parser($registry);

        $schema = $parser->parse($rules);
        $rule = $schema->rules()[0];

        $this->assertEquals('test', $rule->selector());
        $this->assertCount(2, $rule->assertions());
        $this->assertSame($required, $rule->assertions()[0]);
        $this->assertSame($string, $rule->assertions()[1]);
    }

    public function test_it_parses_mixed_strings_and_objects()
    {
        $required = $this->createStub(Assertion::class);
        $string = $this->createStub(Assertion::class);

        $rules = [
            'test' => ['required', $string],
        ];

        $registry = $this->createMock(RegistryContract::class);

        $registry->expects($this->once())
            ->method('resolve')
            ->with('required')
            ->willReturn($required);

        $parser = new Parser($registry);

        $schema = $parser->parse($rules);
        $rule = $schema->rules()[0];

        $this->assertEquals('test', $rule->selector());
        $this->assertCount(2, $rule->assertions());
        $this->assertSame($required, $rule->assertions()[0]);
        $this->assertSame($string, $rule->assertions()[1]);
    }

    public function test_it_throws_when_assertion_list_is_invalid()
    {
        $this->expectException(InvalidAssertionListException::class);

        $rules = [
            'test' => new stdClass,
        ];

        $registry = $this->createStub(RegistryContract::class);

        $parser = new Parser($registry);

        $parser->parse($rules);
    }

    public function test_it_throws_when_assertion_object_is_invalid()
    {
        $this->expectException(InvalidAssertionException::class);

        $rules = [
            'test' => [new stdClass],
        ];

        $registry = $this->createStub(RegistryContract::class);

        $parser = new Parser($registry);

        $parser->parse($rules);
    }

    public function test_it_throws_when_assertion_name_is_unknown()
    {
        $this->expectException(InvalidAssertionException::class);

        $rules = [
            'test' => '',
        ];

        $registry = $this->createStub(RegistryContract::class);

        $parser = new Parser($registry);

        $parser->parse($rules);
    }
}

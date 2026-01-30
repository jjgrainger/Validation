<?php

namespace Validation\Contracts;

interface MessageContract
{
    public function template(): string;

    public function bindings(): array;
}

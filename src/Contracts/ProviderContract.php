<?php

namespace Validation\Contracts;

interface ProviderContract
{
    public function register(RegistryContract $registry): void;
}

<?php

namespace Validation;

use Validation\Contracts\ConfigurationContract;
use Validation\Contracts\ProviderContract;
use Validation\Contracts\ResolverContract;
use Validation\Contracts\TranslatorContract;

class Configuration implements ConfigurationContract
{
    /**
     * Rules array.
     *
     * @var mixed[]
     */
    protected $rules;

    /**
     * Custom messages.
     *
     * @var mixed[]
     */
    protected $messages;

    /**
     * Custom messages aliases.
     *
     * @var mixed[]
     */
    protected $aliases;

    /**
     * Translator
     *
     * @var TranslatorContract|null
     */
    protected $translator;

    /**
     * Registry
     *
     * @var ProviderContract[]
     */
    protected $providers;

    /**
     * Resolver
     *
     * @var ResolverContract|null
     */
    protected $resolver;

    /**
     * constructor
     *
     * @param array<string, mixed> $rules
     * @param array<string, mixed> $config
     */
    public function __construct(array $rules, array $config = [])
    {
        $this->rules = $rules;
        $this->messages = $config['messages'] ?? [];
        $this->aliases = $config['aliases'] ?? [];
        $this->translator = $config['translator'] ?? null;
        $this->providers = $config['providers'] ?? [];
        $this->resolver = $config['resolver'] ?? null;
    }

    /**
     * Rules.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return $this->rules;
    }

    /**
     * Custom messages.
     *
     * @return mixed[]
     */
    public function messages(): array
    {
        return $this->messages;
    }

    /**
     * Custom messages aliases.
     *
     * @return mixed[]
     */
    public function aliases(): array
    {
        return $this->aliases;
    }

    /**
     * Translator
     *
     * @return TranslatorContract|null
     */
    public function translator(): ?TranslatorContract
    {
        return $this->translator;
    }

    /**
     * Registry
     *
     * @return ProviderContract[]
     */
    public function providers(): array
    {
        return $this->providers;
    }

    /**
     * Resolver
     *
     * @return ResolverContract|null
     */
    public function resolver(): ?ResolverContract
    {
        return $this->resolver;
    }
}

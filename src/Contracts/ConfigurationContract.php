<?php

namespace Validation\Contracts;

interface ConfigurationContract
{
    /**
     * Rules.
     *
     * @return array<string, mixed>
     */
    public function rules(): array;

    /**
     * Custom messages.
     *
     * @return array<string, string>
     */
    public function messages(): array;

    /**
     * Custom message aliases.
     *
     * @return array<string, string>
     */
    public function aliases(): array;

    /**
     * Translator.
     *
     * @return TranslatorContract|null
     */
    public function translator(): ?TranslatorContract;

    /**
     * Providers
     *
     * @return ProviderContract[]
     */
    public function providers(): array;
}

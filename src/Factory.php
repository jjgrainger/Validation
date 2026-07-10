<?php

namespace Validation;

use Validation\Contracts\ConfigurationContract;
use Validation\Contracts\FormatterContract;
use Validation\Contracts\RegistryContract;
use Validation\Contracts\SchemaContract;
use Validation\Contracts\TranslatorContract;

class Factory
{
    /**
     * Create a Validator from a Configuration.
     *
     * @param ConfigurationContract $config
     * @return Validator
     */
    public static function makeValidator(ConfigurationContract $config): Validator
    {
        return new Validator(
            self::makeSchema($config),
            self::makeFormatter($config)
        );
    }

    /**
     * Make the Formatter (messages, aliases, translator) from the config.
     *
     * @param ConfigurationContract $config
     * @return FormatterContract
     */
    public static function makeFormatter(ConfigurationContract $config): FormatterContract
    {
        return new Formatter(
            $config->messages(),
            $config->aliases(),
            self::makeTranslator($config)
        );
    }

    /**
     * Make a validation plan from configuration.
     *
     * @param ConfigurationContract $config
     * @return SchemaContract
     */
    public static function makeSchema(ConfigurationContract $config): SchemaContract
    {
        return self::makeParser($config)->parse($config->rules());
    }

    /**
     * Make the Translator (use config or default).
     *
     * @param ConfigurationContract $config
     * @return TranslatorContract
     */
    public static function makeTranslator(ConfigurationContract $config): TranslatorContract
    {
        return $config->translator() ?? new Translator();
    }

    /**
     * Make the Registry and apply Providers.
     *
     * @param ConfigurationContract $config
     * @return RegistryContract
     */
    public static function makeRegistry(ConfigurationContract $config): RegistryContract
    {
        $registry = new Registry;

        $providers = [
            new \Validation\Providers\BaseAssertionsProvider,
            ...$config->providers()
        ];

        foreach ($providers as $provider) {
            $provider->register($registry);
        }

        return $registry;
    }

    /**
     * Make Parser.
     *
     * @param ConfigurationContract $config
     * @return Parser
     */
    public static function makeParser(ConfigurationContract $config): Parser
    {
        return new Parser(
            self::makeRegistry($config)
        );
    }
}

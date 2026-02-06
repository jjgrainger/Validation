<?php

namespace Validation;

use Validation\Contracts\ConfigurationContract;
use Validation\Contracts\FormatterContract;
use Validation\Contracts\RegistryContract;
use Validation\Contracts\ResolverContract;
use Validation\Contracts\StrategyContract;
use Validation\Contracts\TranslatorContract;
use Validation\Providers\CoreRulesProvider;

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
            self::makeStrategy($config),
            self::makeFormatter($config)
        );
    }

    /**
     * Build the Specification (attributes + rules + policy) from the config.
     *
     * @param ConfigurationContract $config
     * @return StrategyContract
     */
    public static function makeStrategy(ConfigurationContract $config): StrategyContract
    {
        $registry = self::makeRegistry($config);
        $resolver = self::makeResolver($config);

        return new Strategy(
            $resolver->resolve($config->rules(), $registry)
        );
    }

    /**
     * Build the Formatter (messages, aliases, translator) from the config.
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
     * Build the Translator (use config or default).
     *
     * @param ConfigurationContract $config
     * @return TranslatorContract
     */
    public static function makeTranslator(ConfigurationContract $config): TranslatorContract
    {
        return $config->translator() ?? new Translator();
    }

    /**
     * Build the Registry (use config or default).
     *
     * @param ConfigurationContract $config
     * @return RegistryContract
     */
    public static function makeRegistry(ConfigurationContract $config): RegistryContract
    {
        $registry = new Registry;

        $providers = [
            new CoreRulesProvider,
            ...$config->providers()
        ];

        foreach ($providers as $provider) {
            $provider->register($registry);
        }

        return $registry;
    }

    /**
     * Build the Resolver (use config or default).
     *
     * @param ConfigurationContract $config
     * @return ResolverContract
     */
    public static function makeResolver(ConfigurationContract $config): ResolverContract
    {
        return $config->resolver() ?? new Resolver();
    }
}

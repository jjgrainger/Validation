<?php

namespace Validation;

use Validation\Contracts\ConfigurationContract;
use Validation\Contracts\FormatterContract;
use Validation\Contracts\RegistryContract;
use Validation\Contracts\ResolverContract;
use Validation\Contracts\RuleContract;
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
     * Make the Validation Strategy from the config.
     *
     * @param ConfigurationContract $config
     * @return StrategyContract
     */
    public static function makeStrategy(ConfigurationContract $config): StrategyContract
    {
        return new Strategy(
            self::makePlan($config)
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
     * @return array<string, RuleContract[]>
     */
    public static function makePlan(ConfigurationContract $config): array
    {
        $registry = self::makeRegistry($config);
        $resolver = self::makeResolver($config);

        return $resolver->resolve($config->rules(), $registry);
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
            new CoreRulesProvider,
            ...$config->providers()
        ];

        foreach ($providers as $provider) {
            $provider->register($registry);
        }

        return $registry;
    }

    /**
     * Make the Resolver (use config or default).
     *
     * @param ConfigurationContract $config
     * @return ResolverContract
     */
    public static function makeResolver(ConfigurationContract $config): ResolverContract
    {
        return $config->resolver() ?? new Resolver();
    }
}

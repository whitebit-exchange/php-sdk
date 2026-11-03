<?php

namespace Whitebit;

/**
 * Represents the available environments for the API with multiple base URLs.
 */
class Environments
{
    /**
     * @var string $base
     */
    public readonly string $base;

    /**
     * @var string $production
     */
    public readonly string $production;

    /**
     * @var string $eu
     */
    public readonly string $eu;

    /**
     * @param string $base The base base URL
     * @param string $production The production base URL
     * @param string $eu The eu base URL
     */
    private function __construct(
        string $base,
        string $production,
        string $eu,
    ) {
        $this->base = $base;
        $this->production = $production;
        $this->eu = $eu;
    }

    /**
     * Default_ environment
     *
     * @return Environments
     */
    public static function Default_(): Environments
    {
        return new self(
            base: 'https://whitebit.com',
            production: 'wss://api.whitebit.com',
            eu: 'wss://api.whitebit.eu'
        );
    }

    /**
     * Create a custom environment with your own URLs
     *
     * @param string $base The base base URL
     * @param string $production The production base URL
     * @param string $eu The eu base URL
     * @return Environments
     */
    public static function custom(string $base, string $production, string $eu): Environments
    {
        return new self(
            base: $base,
            production: $production,
            eu: $eu
        );
    }
}

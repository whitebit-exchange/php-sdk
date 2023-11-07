<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\DTO\Response;

final readonly class AssetProvidersDTO
{
    /**
     * @param  array<string>|null  $deposits
     * @param  array<string>|null  $withdraws
     */
    public function __construct(
        public ?array $deposits = [],
        public ?array $withdraws = []
    ) {
    }

    public static function fromResponseJson(array $providers): self
    {
        return new self(
            $providers['deposit'] ?? null,
            $providers['withdraws'] ?? null,
        );
    }
}

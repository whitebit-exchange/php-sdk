<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

/**
 * Payment provider identifiers for fiat assets (e.g., VISAMASTER, ADVCASH, GEOPAY). Use these identifiers as the network parameter value when making fiat deposits or withdrawals via the API — equivalent to network codes such as ERC20 or TRC20 for crypto assets.
 */
class AssetProviders extends JsonSerializableType
{
    /**
     * @var ?array<string> $deposits
     */
    #[JsonProperty('deposits'), ArrayType(['string'])]
    public ?array $deposits;

    /**
     * @var ?array<string> $withdraws
     */
    #[JsonProperty('withdraws'), ArrayType(['string'])]
    public ?array $withdraws;

    /**
     * @param array{
     *   deposits?: ?array<string>,
     *   withdraws?: ?array<string>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->deposits = $values['deposits'] ?? null;
        $this->withdraws = $values['withdraws'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

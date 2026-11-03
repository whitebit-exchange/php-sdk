<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

/**
 * Currency networks
 */
class AssetNetworks extends JsonSerializableType
{
    /**
     * @var ?array<string> $deposits Networks available for depositing. Absent when deposits are disabled for the asset (can_deposit: false). Examples of assets where the field may be absent: AMB, AVA, A, KZT.
     */
    #[JsonProperty('deposits'), ArrayType(['string'])]
    public ?array $deposits;

    /**
     * @var ?array<string> $withdraws Networks available for withdrawing. Absent when withdrawals are disabled for the asset (can_withdraw: false). Examples: AVA, A (Vaulta).
     */
    #[JsonProperty('withdraws'), ArrayType(['string'])]
    public ?array $withdraws;

    /**
     * @var ?string $default Default network used when no specific network is selected by the user. Absent when multiple networks exist but no explicit default priority has been configured (e.g., AGRS, ANKR, APE, POL).
     */
    #[JsonProperty('default')]
    public ?string $default;

    /**
     * @param array{
     *   deposits?: ?array<string>,
     *   withdraws?: ?array<string>,
     *   default?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->deposits = $values['deposits'] ?? null;
        $this->withdraws = $values['withdraws'] ?? null;
        $this->default = $values['default'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

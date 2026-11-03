<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CollateralAccountBalanceSummaryResponseItem extends JsonSerializableType
{
    /**
     * @var ?string $asset Asset ticker symbol
     */
    #[JsonProperty('asset')]
    public ?string $asset;

    /**
     * @var ?string $balance Total collateral balance for the asset, in the asset's native units
     */
    #[JsonProperty('balance')]
    public ?string $balance;

    /**
     * @var ?string $borrow Amount currently borrowed against the asset, in the asset's native units
     */
    #[JsonProperty('borrow')]
    public ?string $borrow;

    /**
     * @var ?string $availableWithoutBorrow Balance available for use without additional borrowing, in the asset's native units
     */
    #[JsonProperty('availableWithoutBorrow')]
    public ?string $availableWithoutBorrow;

    /**
     * @var ?string $availableWithBorrow Maximum balance available when borrowing capacity is included, in the asset's native units
     */
    #[JsonProperty('availableWithBorrow')]
    public ?string $availableWithBorrow;

    /**
     * @param array{
     *   asset?: ?string,
     *   balance?: ?string,
     *   borrow?: ?string,
     *   availableWithoutBorrow?: ?string,
     *   availableWithBorrow?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->asset = $values['asset'] ?? null;
        $this->balance = $values['balance'] ?? null;
        $this->borrow = $values['borrow'] ?? null;
        $this->availableWithoutBorrow = $values['availableWithoutBorrow'] ?? null;
        $this->availableWithBorrow = $values['availableWithBorrow'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

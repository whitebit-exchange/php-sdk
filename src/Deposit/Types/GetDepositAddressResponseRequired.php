<?php

namespace Whitebit\Deposit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetDepositAddressResponseRequired extends JsonSerializableType
{
    /**
     * @var ?string $fixedFee Fixed deposit fee
     */
    #[JsonProperty('fixedFee')]
    public ?string $fixedFee;

    /**
     * @var ?GetDepositAddressResponseRequiredFlexFee $flexFee Flexible fee - is fee that use percent rate
     */
    #[JsonProperty('flexFee')]
    public ?GetDepositAddressResponseRequiredFlexFee $flexFee;

    /**
     * @var ?string $maxAmount Max amount of deposit accepted by the exchange. Deposits exceeding this amount are rejected.
     */
    #[JsonProperty('maxAmount')]
    public ?string $maxAmount;

    /**
     * @var ?string $minAmount Min amount of deposit accepted by the exchange. Deposits below this amount are rejected.
     */
    #[JsonProperty('minAmount')]
    public ?string $minAmount;

    /**
     * @param array{
     *   fixedFee?: ?string,
     *   flexFee?: ?GetDepositAddressResponseRequiredFlexFee,
     *   maxAmount?: ?string,
     *   minAmount?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->fixedFee = $values['fixedFee'] ?? null;
        $this->flexFee = $values['flexFee'] ?? null;
        $this->maxAmount = $values['maxAmount'] ?? null;
        $this->minAmount = $values['minAmount'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

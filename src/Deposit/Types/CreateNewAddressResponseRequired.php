<?php

namespace Whitebit\Deposit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CreateNewAddressResponseRequired extends JsonSerializableType
{
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
     * @var ?string $fixedFee Fixed deposit fee
     */
    #[JsonProperty('fixedFee')]
    public ?string $fixedFee;

    /**
     * @var ?CreateNewAddressResponseRequiredFlexFee $flexFee Flexible fee - is fee that use percent rate
     */
    #[JsonProperty('flexFee')]
    public ?CreateNewAddressResponseRequiredFlexFee $flexFee;

    /**
     * @param array{
     *   maxAmount?: ?string,
     *   minAmount?: ?string,
     *   fixedFee?: ?string,
     *   flexFee?: ?CreateNewAddressResponseRequiredFlexFee,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->maxAmount = $values['maxAmount'] ?? null;
        $this->minAmount = $values['minAmount'] ?? null;
        $this->fixedFee = $values['fixedFee'] ?? null;
        $this->flexFee = $values['flexFee'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

<?php

namespace Whitebit\Deposit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Flexible fee - is fee that use percent rate
 */
class GetDepositAddressResponseRequiredFlexFee extends JsonSerializableType
{
    /**
     * @var ?string $maxFee Maximum fixed fee charged
     */
    #[JsonProperty('maxFee')]
    public ?string $maxFee;

    /**
     * @var ?string $minFee Minimum fixed fee charged
     */
    #[JsonProperty('minFee')]
    public ?string $minFee;

    /**
     * @var ?string $percent Percent of deposit as fee
     */
    #[JsonProperty('percent')]
    public ?string $percent;

    /**
     * @param array{
     *   maxFee?: ?string,
     *   minFee?: ?string,
     *   percent?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->maxFee = $values['maxFee'] ?? null;
        $this->minFee = $values['minFee'] ?? null;
        $this->percent = $values['percent'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

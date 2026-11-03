<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Withdrawal fees and limits
 */
class MainAccountFeeInfoWithdraw extends JsonSerializableType
{
    /**
     * @var ?string $minFlex Minimum fee amount when flex fee is enabled
     */
    #[JsonProperty('minFlex')]
    public ?string $minFlex;

    /**
     * @var ?string $maxFlex Maximum fee amount when flex fee is enabled
     */
    #[JsonProperty('maxFlex')]
    public ?string $maxFlex;

    /**
     * @var ?string $percentFlex Flex fee percent
     */
    #[JsonProperty('percentFlex')]
    public ?string $percentFlex;

    /**
     * @var ?string $fixed Fixed fee
     */
    #[JsonProperty('fixed')]
    public ?string $fixed;

    /**
     * @var ?string $minAmount Minimum withdrawal amount
     */
    #[JsonProperty('minAmount')]
    public ?string $minAmount;

    /**
     * @var ?string $maxAmount Maximum withdrawal amount
     */
    #[JsonProperty('maxAmount')]
    public ?string $maxAmount;

    /**
     * @param array{
     *   minFlex?: ?string,
     *   maxFlex?: ?string,
     *   percentFlex?: ?string,
     *   fixed?: ?string,
     *   minAmount?: ?string,
     *   maxAmount?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->minFlex = $values['minFlex'] ?? null;
        $this->maxFlex = $values['maxFlex'] ?? null;
        $this->percentFlex = $values['percentFlex'] ?? null;
        $this->fixed = $values['fixed'] ?? null;
        $this->minAmount = $values['minAmount'] ?? null;
        $this->maxAmount = $values['maxAmount'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

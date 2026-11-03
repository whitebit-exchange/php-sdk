<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Fee details for a specific fiat payment provider
 */
class ProviderFeeDetails extends JsonSerializableType
{
    /**
     * @var ?string $ticker Provider identifier
     */
    #[JsonProperty('ticker')]
    public ?string $ticker;

    /**
     * @var ?string $name Human-readable provider name
     */
    #[JsonProperty('name')]
    public ?string $name;

    /**
     * @var ?bool $isDepositable Whether deposits are enabled via this provider
     */
    #[JsonProperty('is_depositable')]
    public ?bool $isDepositable;

    /**
     * @var ?bool $isApiDepositable Whether API deposits are enabled via this provider
     */
    #[JsonProperty('is_api_depositable')]
    public ?bool $isApiDepositable;

    /**
     * @var ?bool $isWithdrawal Whether withdrawals are enabled via this provider
     */
    #[JsonProperty('is_withdrawal')]
    public ?bool $isWithdrawal;

    /**
     * @var ?bool $isApiWithdrawal Whether API withdrawals are enabled via this provider
     */
    #[JsonProperty('is_api_withdrawal')]
    public ?bool $isApiWithdrawal;

    /**
     * @var ?string $maxAmount Maximum transfer amount. `"0"` means unlimited.
     */
    #[JsonProperty('max_amount')]
    public ?string $maxAmount;

    /**
     * @var ?string $minAmount Minimum transfer amount
     */
    #[JsonProperty('min_amount')]
    public ?string $minAmount;

    /**
     * @var ?string $fixed Fixed fee amount per transaction. `null` if no fixed fee applies.
     */
    #[JsonProperty('fixed')]
    public ?string $fixed;

    /**
     * @var ?ProviderFeeDetailsFlex $flex Percentage-based (flexible) fee. `null` if no flexible fee applies.
     */
    #[JsonProperty('flex')]
    public ?ProviderFeeDetailsFlex $flex;

    /**
     * @param array{
     *   ticker?: ?string,
     *   name?: ?string,
     *   isDepositable?: ?bool,
     *   isApiDepositable?: ?bool,
     *   isWithdrawal?: ?bool,
     *   isApiWithdrawal?: ?bool,
     *   maxAmount?: ?string,
     *   minAmount?: ?string,
     *   fixed?: ?string,
     *   flex?: ?ProviderFeeDetailsFlex,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->ticker = $values['ticker'] ?? null;
        $this->name = $values['name'] ?? null;
        $this->isDepositable = $values['isDepositable'] ?? null;
        $this->isApiDepositable = $values['isApiDepositable'] ?? null;
        $this->isWithdrawal = $values['isWithdrawal'] ?? null;
        $this->isApiWithdrawal = $values['isApiWithdrawal'] ?? null;
        $this->maxAmount = $values['maxAmount'] ?? null;
        $this->minAmount = $values['minAmount'] ?? null;
        $this->fixed = $values['fixed'] ?? null;
        $this->flex = $values['flex'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

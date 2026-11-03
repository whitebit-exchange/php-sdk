<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;
use Whitebit\Core\Types\Union;

/**
 * Fee and limit details for a single asset. For crypto assets, `withdraw` and `deposit` are flat fee objects. For fiat assets with providers, they are objects keyed by provider ID.
 */
class FeeInfo extends JsonSerializableType
{
    /**
     * @var ?string $ticker Asset ticker symbol
     */
    #[JsonProperty('ticker')]
    public ?string $ticker;

    /**
     * @var ?string $name Human-readable asset name
     */
    #[JsonProperty('name')]
    public ?string $name;

    /**
     * @var ?array<string> $providers Payment provider identifiers used as the network parameter value for fiat deposits and withdrawals via the API. See GET /api/v4/public/assets providers field for context.
     */
    #[JsonProperty('providers'), ArrayType(['string'])]
    public ?array $providers;

    /**
     * @var (
     *    FeeDetails
     *   |array<string, ProviderFeeDetails>
     * )|null $deposit Deposit fee details. For crypto assets, this is a flat object with `max_amount`, `min_amount`, `fixed`, and `flex` fields. For fiat assets with providers, this is an object keyed by provider ID, where each value contains provider-specific fee details.
     */
    #[JsonProperty('deposit'), Union(FeeDetails::class, ['string' => ProviderFeeDetails::class], 'null')]
    public FeeDetails|array|null $deposit;

    /**
     * @var (
     *    FeeDetails
     *   |array<string, ProviderFeeDetails>
     * )|null $withdraw Withdrawal fee details. For crypto assets, this is a flat object with `max_amount`, `min_amount`, `fixed`, and `flex` fields. For fiat assets with providers, this is an object keyed by provider ID, where each value contains provider-specific fee details.
     */
    #[JsonProperty('withdraw'), Union(FeeDetails::class, ['string' => ProviderFeeDetails::class], 'null')]
    public FeeDetails|array|null $withdraw;

    /**
     * @var ?bool $isDepositable Indicates whether deposits are enabled for the currency. May be absent from the response; absence should be treated as equivalent to false.
     */
    #[JsonProperty('is_depositable')]
    public ?bool $isDepositable;

    /**
     * @var ?bool $isWithdrawal Indicates whether withdrawals are enabled for the currency. May be absent from the response; absence should be treated as equivalent to false.
     */
    #[JsonProperty('is_withdrawal')]
    public ?bool $isWithdrawal;

    /**
     * @var ?bool $isApiWithdrawal Whether API withdrawals are enabled
     */
    #[JsonProperty('is_api_withdrawal')]
    public ?bool $isApiWithdrawal;

    /**
     * @var ?bool $isApiDepositable Whether API deposits are enabled
     */
    #[JsonProperty('is_api_depositable')]
    public ?bool $isApiDepositable;

    /**
     * @param array{
     *   ticker?: ?string,
     *   name?: ?string,
     *   providers?: ?array<string>,
     *   deposit?: (
     *    FeeDetails
     *   |array<string, ProviderFeeDetails>
     * )|null,
     *   withdraw?: (
     *    FeeDetails
     *   |array<string, ProviderFeeDetails>
     * )|null,
     *   isDepositable?: ?bool,
     *   isWithdrawal?: ?bool,
     *   isApiWithdrawal?: ?bool,
     *   isApiDepositable?: ?bool,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->ticker = $values['ticker'] ?? null;
        $this->name = $values['name'] ?? null;
        $this->providers = $values['providers'] ?? null;
        $this->deposit = $values['deposit'] ?? null;
        $this->withdraw = $values['withdraw'] ?? null;
        $this->isDepositable = $values['isDepositable'] ?? null;
        $this->isWithdrawal = $values['isWithdrawal'] ?? null;
        $this->isApiWithdrawal = $values['isApiWithdrawal'] ?? null;
        $this->isApiDepositable = $values['isApiDepositable'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

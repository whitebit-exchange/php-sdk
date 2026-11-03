<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class Asset extends JsonSerializableType
{
    /**
     * @var ?string $name Full name of cryptocurrency
     */
    #[JsonProperty('name')]
    public ?string $name;

    /**
     * @var ?int $unifiedCryptoassetId Unique ID of cryptocurrency assigned by Unified Cryptoasset ID, 0 if unknown
     */
    #[JsonProperty('unified_cryptoasset_id')]
    public ?int $unifiedCryptoassetId;

    /**
     * @var ?bool $canWithdraw Indicates withdrawal status (enabled or disabled)
     */
    #[JsonProperty('can_withdraw')]
    public ?bool $canWithdraw;

    /**
     * @var ?bool $canDeposit Indicates deposit status (enabled or disabled)
     */
    #[JsonProperty('can_deposit')]
    public ?bool $canDeposit;

    /**
     * @var ?string $minWithdraw Minimum withdrawal amount for the asset
     */
    #[JsonProperty('min_withdraw')]
    public ?string $minWithdraw;

    /**
     * @var ?string $maxWithdraw Maximum withdrawal amount for the asset
     */
    #[JsonProperty('max_withdraw')]
    public ?string $maxWithdraw;

    /**
     * @var ?string $makerFee Maker fee expressed as a direct percentage value (e.g., "0.1" means 0.1%). GET /api/v4/public/markets reports the per-market `makerFee` in the same format.
     */
    #[JsonProperty('maker_fee')]
    public ?string $makerFee;

    /**
     * @var ?string $takerFee Taker fee expressed as a direct percentage value (e.g., "0.1" means 0.1%). GET /api/v4/public/markets reports the per-market `takerFee` in the same format.
     */
    #[JsonProperty('taker_fee')]
    public ?string $takerFee;

    /**
     * @var ?string $minDeposit Min deposit amount
     */
    #[JsonProperty('min_deposit')]
    public ?string $minDeposit;

    /**
     * @var ?string $maxDeposit Max deposit amount; 0 if unlimited
     */
    #[JsonProperty('max_deposit')]
    public ?string $maxDeposit;

    /**
     * @var ?int $currencyPrecision Max number of digits to the right of the decimal point
     */
    #[JsonProperty('currency_precision')]
    public ?int $currencyPrecision;

    /**
     * @var ?bool $isMemo Indicates whether the asset requires a memo address
     */
    #[JsonProperty('is_memo')]
    public ?bool $isMemo;

    /**
     * @var ?AssetMemo $memo Indicates whether the asset requires a memo for deposits and withdrawals
     */
    #[JsonProperty('memo')]
    public ?AssetMemo $memo;

    /**
     * @var ?AssetNetworks $networks Currency networks
     */
    #[JsonProperty('networks')]
    public ?AssetNetworks $networks;

    /**
     * @var ?AssetLimits $limits Currency limits by each network. May be absent from the response.
     */
    #[JsonProperty('limits')]
    public ?AssetLimits $limits;

    /**
     * @var ?array<string, int> $confirmations Required blockchain confirmations for deposits, mapped by network name (e.g., {"BTC": 2, "ERC20": 20}). Absent for fiat currencies, demo assets, and internal exchange tokens (e.g., UAH, EUR, DBTC, DUSDT). Individual network keys may also be absent if a network was historically supported but is currently disabled.
     */
    #[JsonProperty('confirmations'), ArrayType(['string' => 'integer'])]
    public ?array $confirmations;

    /**
     * @var ?AssetProviders $providers Payment provider identifiers for fiat assets (e.g., VISAMASTER, ADVCASH, GEOPAY). Use these identifiers as the network parameter value when making fiat deposits or withdrawals via the API — equivalent to network codes such as ERC20 or TRC20 for crypto assets.
     */
    #[JsonProperty('providers')]
    public ?AssetProviders $providers;

    /**
     * @param array{
     *   name?: ?string,
     *   unifiedCryptoassetId?: ?int,
     *   canWithdraw?: ?bool,
     *   canDeposit?: ?bool,
     *   minWithdraw?: ?string,
     *   maxWithdraw?: ?string,
     *   makerFee?: ?string,
     *   takerFee?: ?string,
     *   minDeposit?: ?string,
     *   maxDeposit?: ?string,
     *   currencyPrecision?: ?int,
     *   isMemo?: ?bool,
     *   memo?: ?AssetMemo,
     *   networks?: ?AssetNetworks,
     *   limits?: ?AssetLimits,
     *   confirmations?: ?array<string, int>,
     *   providers?: ?AssetProviders,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->name = $values['name'] ?? null;
        $this->unifiedCryptoassetId = $values['unifiedCryptoassetId'] ?? null;
        $this->canWithdraw = $values['canWithdraw'] ?? null;
        $this->canDeposit = $values['canDeposit'] ?? null;
        $this->minWithdraw = $values['minWithdraw'] ?? null;
        $this->maxWithdraw = $values['maxWithdraw'] ?? null;
        $this->makerFee = $values['makerFee'] ?? null;
        $this->takerFee = $values['takerFee'] ?? null;
        $this->minDeposit = $values['minDeposit'] ?? null;
        $this->maxDeposit = $values['maxDeposit'] ?? null;
        $this->currencyPrecision = $values['currencyPrecision'] ?? null;
        $this->isMemo = $values['isMemo'] ?? null;
        $this->memo = $values['memo'] ?? null;
        $this->networks = $values['networks'] ?? null;
        $this->limits = $values['limits'] ?? null;
        $this->confirmations = $values['confirmations'] ?? null;
        $this->providers = $values['providers'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

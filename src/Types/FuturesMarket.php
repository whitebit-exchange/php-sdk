<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class FuturesMarket extends JsonSerializableType
{
    /**
     * @var ?string $tickerId Identifier of a ticker with delimiter to separate base/target
     */
    #[JsonProperty('ticker_id')]
    public ?string $tickerId;

    /**
     * @var ?string $stockCurrency Symbol/currency code of base pair
     */
    #[JsonProperty('stock_currency')]
    public ?string $stockCurrency;

    /**
     * @var ?string $moneyCurrency Symbol/currency code of target pair
     */
    #[JsonProperty('money_currency')]
    public ?string $moneyCurrency;

    /**
     * @var ?string $lastPrice Last transacted price of base currency based on given target currency
     */
    #[JsonProperty('last_price')]
    public ?string $lastPrice;

    /**
     * @var ?string $stockVolume 24 hour trading volume in base pair volume
     */
    #[JsonProperty('stock_volume')]
    public ?string $stockVolume;

    /**
     * @var ?string $moneyVolume 24 hour trading volume in target pair volume
     */
    #[JsonProperty('money_volume')]
    public ?string $moneyVolume;

    /**
     * @var ?string $bid Current highest bid price
     */
    #[JsonProperty('bid')]
    public ?string $bid;

    /**
     * @var ?string $ask Current lowest ask price
     */
    #[JsonProperty('ask')]
    public ?string $ask;

    /**
     * @var ?string $high Rolling 24-hours highest transaction price
     */
    #[JsonProperty('high')]
    public ?string $high;

    /**
     * @var ?string $low Rolling 24-hours lowest transaction price
     */
    #[JsonProperty('low')]
    public ?string $low;

    /**
     * @var ?value-of<FuturesMarketProductType> $productType Derivative product type for the market. Currently always `Perpetual`.
     */
    #[JsonProperty('product_type')]
    public ?string $productType;

    /**
     * @var ?string $openInterest Current open interest in contracts (point-in-time snapshot, not a 24-hour delta or volume).
     */
    #[JsonProperty('open_interest')]
    public ?string $openInterest;

    /**
     * @var ?string $indexPrice Underlying index price
     */
    #[JsonProperty('index_price')]
    public ?string $indexPrice;

    /**
     * @var ?string $indexName Name of the underlying index if any
     */
    #[JsonProperty('index_name')]
    public ?string $indexName;

    /**
     * @var ?string $indexCurrency Underlying currency for index
     */
    #[JsonProperty('index_currency')]
    public ?string $indexCurrency;

    /**
     * @var ?string $fundingRate Predicted funding rate for the next settlement interval. Fluctuates in real time until settlement occurs. See GET /api/v4/public/funding-history/{market} for historical funding rate records.
     */
    #[JsonProperty('funding_rate')]
    public ?string $fundingRate;

    /**
     * @var ?string $fundingCap Upper bound that the funding rate can reach for the market. Served from the last successfully refreshed funding snapshot, so a temporary source outage does not drop the field. Returns `null` only when no snapshot has been loaded since service start.
     */
    #[JsonProperty('funding_cap')]
    public ?string $fundingCap;

    /**
     * @var ?string $fundingFloor Lower bound that the funding rate can reach for the market. Served from the last successfully refreshed funding snapshot, so a temporary source outage does not drop the field. Returns `null` only when no snapshot has been loaded since service start.
     */
    #[JsonProperty('funding_floor')]
    public ?string $fundingFloor;

    /**
     * @var ?string $nextFundingRateTimestamp Unix timestamp in milliseconds of the next funding settlement. 13-digit value (millisecond precision).
     */
    #[JsonProperty('next_funding_rate_timestamp')]
    public ?string $nextFundingRateTimestamp;

    /**
     * @var ?array<string, int> $brackets Leverage brackets defining position size limits. Object keys are leverage multipliers (e.g., "1", "2", "5", "10", "20", "50", "100"). Values are the maximum allowed open position size in USDT equivalent at the corresponding leverage level.
     */
    #[JsonProperty('brackets'), ArrayType(['string' => 'integer'])]
    public ?array $brackets;

    /**
     * @var ?int $maxLeverage Maximum leverage multiplier allowed for the market.
     */
    #[JsonProperty('max_leverage')]
    public ?int $maxLeverage;

    /**
     * @var ?int $fundingIntervalMinutes Funding interval in minutes
     */
    #[JsonProperty('funding_interval_minutes')]
    public ?int $fundingIntervalMinutes;

    /**
     * @param array{
     *   tickerId?: ?string,
     *   stockCurrency?: ?string,
     *   moneyCurrency?: ?string,
     *   lastPrice?: ?string,
     *   stockVolume?: ?string,
     *   moneyVolume?: ?string,
     *   bid?: ?string,
     *   ask?: ?string,
     *   high?: ?string,
     *   low?: ?string,
     *   productType?: ?value-of<FuturesMarketProductType>,
     *   openInterest?: ?string,
     *   indexPrice?: ?string,
     *   indexName?: ?string,
     *   indexCurrency?: ?string,
     *   fundingRate?: ?string,
     *   fundingCap?: ?string,
     *   fundingFloor?: ?string,
     *   nextFundingRateTimestamp?: ?string,
     *   brackets?: ?array<string, int>,
     *   maxLeverage?: ?int,
     *   fundingIntervalMinutes?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->tickerId = $values['tickerId'] ?? null;
        $this->stockCurrency = $values['stockCurrency'] ?? null;
        $this->moneyCurrency = $values['moneyCurrency'] ?? null;
        $this->lastPrice = $values['lastPrice'] ?? null;
        $this->stockVolume = $values['stockVolume'] ?? null;
        $this->moneyVolume = $values['moneyVolume'] ?? null;
        $this->bid = $values['bid'] ?? null;
        $this->ask = $values['ask'] ?? null;
        $this->high = $values['high'] ?? null;
        $this->low = $values['low'] ?? null;
        $this->productType = $values['productType'] ?? null;
        $this->openInterest = $values['openInterest'] ?? null;
        $this->indexPrice = $values['indexPrice'] ?? null;
        $this->indexName = $values['indexName'] ?? null;
        $this->indexCurrency = $values['indexCurrency'] ?? null;
        $this->fundingRate = $values['fundingRate'] ?? null;
        $this->fundingCap = $values['fundingCap'] ?? null;
        $this->fundingFloor = $values['fundingFloor'] ?? null;
        $this->nextFundingRateTimestamp = $values['nextFundingRateTimestamp'] ?? null;
        $this->brackets = $values['brackets'] ?? null;
        $this->maxLeverage = $values['maxLeverage'] ?? null;
        $this->fundingIntervalMinutes = $values['fundingIntervalMinutes'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

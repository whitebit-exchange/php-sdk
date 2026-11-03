<?php

namespace Whitebit\PublicApiV4\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetApiV4PublicMarketsResponseItem extends JsonSerializableType
{
    /**
     * @var string $name Market pair name
     */
    #[JsonProperty('name')]
    public string $name;

    /**
     * @var string $stock Ticker of stock currency
     */
    #[JsonProperty('stock')]
    public string $stock;

    /**
     * @var string $money Ticker of money currency. Perpetual futures markets report `USDT` as the money currency.
     */
    #[JsonProperty('money')]
    public string $money;

    /**
     * @var string $stockPrec Maximum number of decimal places for the base (stock) currency quantity. Represented as a stringified integer.
     */
    #[JsonProperty('stockPrec')]
    public string $stockPrec;

    /**
     * @var string $moneyPrec Maximum number of decimal places for the quote (money) currency amount. Represented as a stringified integer.
     */
    #[JsonProperty('moneyPrec')]
    public string $moneyPrec;

    /**
     * @var string $feePrec Maximum number of decimal places used when calculating fees. Represented as a stringified integer.
     */
    #[JsonProperty('feePrec')]
    public string $feePrec;

    /**
     * @var string $makerFee Default maker fee as a percentage value (e.g., `"0.1"` means 0.1%). Divide by 100 to convert to a decimal ratio. `GET /api/v4/public/assets` reports `maker_fee` in the same format.
     */
    #[JsonProperty('makerFee')]
    public string $makerFee;

    /**
     * @var string $takerFee Default taker fee as a percentage value (e.g., `"0.1"` means 0.1%). Divide by 100 to convert to a decimal ratio. `GET /api/v4/public/assets` reports `taker_fee` in the same format.
     */
    #[JsonProperty('takerFee')]
    public string $takerFee;

    /**
     * @var string $minAmount Minimum order quantity in the base (stock) currency.
     */
    #[JsonProperty('minAmount')]
    public string $minAmount;

    /**
     * @var string $minTotal Minimum order total in the quote (money) currency.
     */
    #[JsonProperty('minTotal')]
    public string $minTotal;

    /**
     * @var string $maxTotal Maximum order total (quantity × price) in the quote (money) currency. `"0"` indicates no upper limit.
     */
    #[JsonProperty('maxTotal')]
    public string $maxTotal;

    /**
     * @var bool $tradesEnabled Indicates whether trading is enabled. The response includes only markets enabled for trading, so the value is always `true`.
     */
    #[JsonProperty('tradesEnabled')]
    public bool $tradesEnabled;

    /**
     * @var bool $isCollateral Indicates whether margin trading is enabled
     */
    #[JsonProperty('isCollateral')]
    public bool $isCollateral;

    /**
     * @var value-of<GetApiV4PublicMarketsResponseItemType> $type Market type. Possible values: spot, futures, tradfiFutures
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var bool $isTradFiFutures Indicates whether the market is a traditional-finance (TradFi) futures market. Always paired with `type: tradfiFutures`. TradFi futures markets are coming soon and are not yet returned; once available they are region-gated and omitted from the response entirely where not available.
     */
    #[JsonProperty('isTradFiFutures')]
    public bool $isTradFiFutures;

    /**
     * @var ?int $delistedAt Announced delisting date as a Unix timestamp in seconds. `null` when no delisting is announced for the market. The field is always present in the response.
     */
    #[JsonProperty('delistedAt')]
    public ?int $delistedAt;

    /**
     * @param array{
     *   name: string,
     *   stock: string,
     *   money: string,
     *   stockPrec: string,
     *   moneyPrec: string,
     *   feePrec: string,
     *   makerFee: string,
     *   takerFee: string,
     *   minAmount: string,
     *   minTotal: string,
     *   maxTotal: string,
     *   tradesEnabled: bool,
     *   isCollateral: bool,
     *   type: value-of<GetApiV4PublicMarketsResponseItemType>,
     *   isTradFiFutures: bool,
     *   delistedAt?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->name = $values['name'];
        $this->stock = $values['stock'];
        $this->money = $values['money'];
        $this->stockPrec = $values['stockPrec'];
        $this->moneyPrec = $values['moneyPrec'];
        $this->feePrec = $values['feePrec'];
        $this->makerFee = $values['makerFee'];
        $this->takerFee = $values['takerFee'];
        $this->minAmount = $values['minAmount'];
        $this->minTotal = $values['minTotal'];
        $this->maxTotal = $values['maxTotal'];
        $this->tradesEnabled = $values['tradesEnabled'];
        $this->isCollateral = $values['isCollateral'];
        $this->type = $values['type'];
        $this->isTradFiFutures = $values['isTradFiFutures'];
        $this->delistedAt = $values['delistedAt'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

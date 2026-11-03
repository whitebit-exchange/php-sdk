<?php

namespace Whitebit\PublicApiV4\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetApiV4PublicTradesMarketResponseItem extends JsonSerializableType
{
    /**
     * @var int $tradeId A unique ID associated with the trade for the currency pair transaction Note: Unix timestamp does not qualify as trade_id.
     */
    #[JsonProperty('tradeID')]
    public int $tradeId;

    /**
     * @var string $price Transaction price in quote pair volume.
     */
    #[JsonProperty('price')]
    public string $price;

    /**
     * @var string $quoteVolume Transaction amount in the quote (stock) currency. In a BTC_USDT market, the value is the BTC amount. Note: WhiteBIT uses a reversed naming convention compared to standard exchange terminology — the stock/asset currency is called 'quote' here.
     */
    #[JsonProperty('quote_volume')]
    public string $quoteVolume;

    /**
     * @var string $baseVolume Transaction amount in the base (money) currency. In a BTC_USDT market, the value is the USDT amount. Note: WhiteBIT uses a reversed naming convention compared to standard exchange terminology — the settlement/pricing currency is called 'base' here.
     */
    #[JsonProperty('base_volume')]
    public string $baseVolume;

    /**
     * @var int $tradeTimestamp Unix timestamp in seconds (UTC). Identifies when the transaction occurred.
     */
    #[JsonProperty('trade_timestamp')]
    public int $tradeTimestamp;

    /**
     * @var value-of<GetApiV4PublicTradesMarketResponseItemType> $type Used to determine whether or not the transaction originated as a buy or sell. Buy – Identifies an ask that was removed from the order book. Sell – Identifies a bid that was removed from the order book.
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var bool $rpi Indicates that the trade originates from a Retail Price Improvement (RPI) order.
     */
    #[JsonProperty('rpi')]
    public bool $rpi;

    /**
     * @param array{
     *   tradeId: int,
     *   price: string,
     *   quoteVolume: string,
     *   baseVolume: string,
     *   tradeTimestamp: int,
     *   type: value-of<GetApiV4PublicTradesMarketResponseItemType>,
     *   rpi: bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->tradeId = $values['tradeId'];
        $this->price = $values['price'];
        $this->quoteVolume = $values['quoteVolume'];
        $this->baseVolume = $values['baseVolume'];
        $this->tradeTimestamp = $values['tradeTimestamp'];
        $this->type = $values['type'];
        $this->rpi = $values['rpi'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

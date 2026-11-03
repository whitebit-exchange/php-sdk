<?php

namespace Whitebit\PublicApiV4\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetApiV4PublicTickerResponseValue extends JsonSerializableType
{
    /**
     * @var ?int $baseId CoinMarketCap ID of base currency; 0 - if unknown
     */
    #[JsonProperty('base_id')]
    public ?int $baseId;

    /**
     * @var ?int $quoteId CoinMarketCap ID of quote currency; 0 - if unknown
     */
    #[JsonProperty('quote_id')]
    public ?int $quoteId;

    /**
     * @var ?string $lastPrice Most recent trade price in the quote currency.
     */
    #[JsonProperty('last_price')]
    public ?string $lastPrice;

    /**
     * @var ?string $quoteVolume Rolling 24-hour trading volume in the quote currency.
     */
    #[JsonProperty('quote_volume')]
    public ?string $quoteVolume;

    /**
     * @var ?string $baseVolume Rolling 24-hour trading volume in the base currency.
     */
    #[JsonProperty('base_volume')]
    public ?string $baseVolume;

    /**
     * @var ?bool $isFrozen Indicates whether trading is disabled for the market pair.
     */
    #[JsonProperty('isFrozen')]
    public ?bool $isFrozen;

    /**
     * @var ?string $change Percentage change between the rolling 24-hour open price and the last traded price.
     */
    #[JsonProperty('change')]
    public ?string $change;

    /**
     * @param array{
     *   baseId?: ?int,
     *   quoteId?: ?int,
     *   lastPrice?: ?string,
     *   quoteVolume?: ?string,
     *   baseVolume?: ?string,
     *   isFrozen?: ?bool,
     *   change?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->baseId = $values['baseId'] ?? null;
        $this->quoteId = $values['quoteId'] ?? null;
        $this->lastPrice = $values['lastPrice'] ?? null;
        $this->quoteVolume = $values['quoteVolume'] ?? null;
        $this->baseVolume = $values['baseVolume'] ?? null;
        $this->isFrozen = $values['isFrozen'] ?? null;
        $this->change = $values['change'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

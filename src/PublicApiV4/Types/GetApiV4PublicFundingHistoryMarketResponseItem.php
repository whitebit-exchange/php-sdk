<?php

namespace Whitebit\PublicApiV4\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetApiV4PublicFundingHistoryMarketResponseItem extends JsonSerializableType
{
    /**
     * @var string $fundingTime Unix timestamp in seconds when the funding settlement executed.
     */
    #[JsonProperty('fundingTime')]
    public string $fundingTime;

    /**
     * @var string $fundingRate Funding rate applied at the settlement interval. Each record represents a historical settlement event.
     */
    #[JsonProperty('fundingRate')]
    public string $fundingRate;

    /**
     * @var string $market Futures market pair name (e.g., `BTC_PERP`).
     */
    #[JsonProperty('market')]
    public string $market;

    /**
     * @var string $settlementPrice Mark price in the quote currency at the time of funding settlement.
     */
    #[JsonProperty('settlementPrice')]
    public string $settlementPrice;

    /**
     * @var string $rateCalculatedTime Unix timestamp in seconds when the funding rate was calculated. The rate is computed before the actual settlement.
     */
    #[JsonProperty('rateCalculatedTime')]
    public string $rateCalculatedTime;

    /**
     * @param array{
     *   fundingTime: string,
     *   fundingRate: string,
     *   market: string,
     *   settlementPrice: string,
     *   rateCalculatedTime: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->fundingTime = $values['fundingTime'];
        $this->fundingRate = $values['fundingRate'];
        $this->market = $values['market'];
        $this->settlementPrice = $values['settlementPrice'];
        $this->rateCalculatedTime = $values['rateCalculatedTime'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

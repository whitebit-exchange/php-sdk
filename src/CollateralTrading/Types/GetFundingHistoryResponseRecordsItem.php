<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetFundingHistoryResponseRecordsItem extends JsonSerializableType
{
    /**
     * @var ?string $market Market name
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?string $fundingTime Funding time in Unix timestamp format
     */
    #[JsonProperty('fundingTime')]
    public ?string $fundingTime;

    /**
     * @var ?string $fundingRate Funding rate applied
     */
    #[JsonProperty('fundingRate')]
    public ?string $fundingRate;

    /**
     * @var ?string $fundingAmount Funding amount paid or received
     */
    #[JsonProperty('fundingAmount')]
    public ?string $fundingAmount;

    /**
     * @var ?string $positionAmount Position amount at funding time
     */
    #[JsonProperty('positionAmount')]
    public ?string $positionAmount;

    /**
     * @var ?string $settlementPrice Settlement price used for funding calculation
     */
    #[JsonProperty('settlementPrice')]
    public ?string $settlementPrice;

    /**
     * @var ?string $rateCalculatedTime Time when the funding rate was calculated in Unix timestamp format
     */
    #[JsonProperty('rateCalculatedTime')]
    public ?string $rateCalculatedTime;

    /**
     * @param array{
     *   market?: ?string,
     *   fundingTime?: ?string,
     *   fundingRate?: ?string,
     *   fundingAmount?: ?string,
     *   positionAmount?: ?string,
     *   settlementPrice?: ?string,
     *   rateCalculatedTime?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->market = $values['market'] ?? null;
        $this->fundingTime = $values['fundingTime'] ?? null;
        $this->fundingRate = $values['fundingRate'] ?? null;
        $this->fundingAmount = $values['fundingAmount'] ?? null;
        $this->positionAmount = $values['positionAmount'] ?? null;
        $this->settlementPrice = $values['settlementPrice'] ?? null;
        $this->rateCalculatedTime = $values['rateCalculatedTime'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

<?php

namespace Whitebit\CollateralTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetPositionsHistoryRequest extends JsonSerializableType
{
    /**
     * Filter by specific market. Example: BTC_USDT
     *
     * If not specified, returns position history for all markets.
     *
     * @var ?string $market
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?int $positionId Filter by specific position identifier. If not specified, returns history for all positions.
     */
    #[JsonProperty('positionId')]
    public ?int $positionId;

    /**
     * @var ?int $startDate Start of the query window as a Unix timestamp in seconds. Optional, no default. Must be ≤ `endDate`.
     */
    #[JsonProperty('startDate')]
    public ?int $startDate;

    /**
     * @var ?int $endDate End of the query window as a Unix timestamp in seconds. Optional, no default. Must be ≥ `startDate` and ≤ `now + 1s`; violating values are rejected with a validation error.
     */
    #[JsonProperty('endDate')]
    public ?int $endDate;

    /**
     * @var ?string $request
     */
    #[JsonProperty('request')]
    public ?string $request;

    /**
     * @var ?int $nonce
     */
    #[JsonProperty('nonce')]
    public ?int $nonce;

    /**
     * @param array{
     *   market?: ?string,
     *   positionId?: ?int,
     *   startDate?: ?int,
     *   endDate?: ?int,
     *   request?: ?string,
     *   nonce?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->market = $values['market'] ?? null;
        $this->positionId = $values['positionId'] ?? null;
        $this->startDate = $values['startDate'] ?? null;
        $this->endDate = $values['endDate'] ?? null;
        $this->request = $values['request'] ?? null;
        $this->nonce = $values['nonce'] ?? null;
    }
}

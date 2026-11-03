<?php

namespace Whitebit\CollateralTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetClosedPositionsPnlRequest extends JsonSerializableType
{
    /**
     * @var ?int $startDate Start of the query window as a Unix timestamp in seconds, applied to the position close time. Optional, no default. Must be ≤ `endDate`.
     */
    #[JsonProperty('startDate')]
    public ?int $startDate;

    /**
     * @var ?int $endDate End of the query window as a Unix timestamp in seconds, applied to the position close time. Optional, no default. Must be ≥ `startDate` and ≤ `now + 1s`.
     */
    #[JsonProperty('endDate')]
    public ?int $endDate;

    /**
     * @var ?int $limit Maximum number of records to return. Default: `50`. Minimum: `1`. Maximum: `100`.
     */
    #[JsonProperty('limit')]
    public ?int $limit;

    /**
     * @var ?int $offset Number of records to skip. Default: `0`. The sum of `offset` and `limit` must not exceed 10000.
     */
    #[JsonProperty('offset')]
    public ?int $offset;

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
     *   startDate?: ?int,
     *   endDate?: ?int,
     *   limit?: ?int,
     *   offset?: ?int,
     *   request?: ?string,
     *   nonce?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->startDate = $values['startDate'] ?? null;
        $this->endDate = $values['endDate'] ?? null;
        $this->limit = $values['limit'] ?? null;
        $this->offset = $values['offset'] ?? null;
        $this->request = $values['request'] ?? null;
        $this->nonce = $values['nonce'] ?? null;
    }
}

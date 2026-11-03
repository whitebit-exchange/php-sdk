<?php

namespace Whitebit\SpotTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\SpotTrading\Types\GetDelistingOrderHistoryRequestStatus;

class GetDelistingOrderHistoryRequest extends JsonSerializableType
{
    /**
     * @var ?string $market Trading pair to filter by. Format: `BASE_QUOTE` (e.g., `BTC_USDT`), matching the pattern `^[A-Z0-9]+_[A-Z0-9]+$`. Omit to retrieve delisting orders across all markets.
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?value-of<GetDelistingOrderHistoryRequestStatus> $status Category filter — distinct from the response `status` field. `filled` returns only reverse close orders (`clientOrderId` prefixed with `delisting-`), which carry `delistingKind` = `reverse` and response `status` = `filled`. `delisting` returns only orders canceled at delisting, which carry `delistingKind` = `canceled` and response `status` = `canceled`. Omit to return both categories merged.
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var ?int $startDate Start of the query window as a Unix timestamp in seconds. Default: `now - 30 days`. Must not be later than `endDate`.
     */
    #[JsonProperty('startDate')]
    public ?int $startDate;

    /**
     * @var ?int $endDate End of the query window as a Unix timestamp in seconds. Default: `now`. Values greater than the current time are clamped to `now`. The maximum span between `startDate` and `endDate` is 31 days.
     */
    #[JsonProperty('endDate')]
    public ?int $endDate;

    /**
     * @var ?int $offset Number of records to skip. Default: `0`. The sum of `offset` and `limit` must not exceed 10000.
     */
    #[JsonProperty('offset')]
    public ?int $offset;

    /**
     * @var ?int $limit Maximum number of records to return. Default: `500`. Minimum: `1`. Maximum: `500`.
     */
    #[JsonProperty('limit')]
    public ?int $limit;

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
     *   status?: ?value-of<GetDelistingOrderHistoryRequestStatus>,
     *   startDate?: ?int,
     *   endDate?: ?int,
     *   offset?: ?int,
     *   limit?: ?int,
     *   request?: ?string,
     *   nonce?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->market = $values['market'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->startDate = $values['startDate'] ?? null;
        $this->endDate = $values['endDate'] ?? null;
        $this->offset = $values['offset'] ?? null;
        $this->limit = $values['limit'] ?? null;
        $this->request = $values['request'] ?? null;
        $this->nonce = $values['nonce'] ?? null;
    }
}

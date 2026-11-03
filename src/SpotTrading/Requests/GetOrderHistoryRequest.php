<?php

namespace Whitebit\SpotTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\SpotTrading\Types\GetOrderHistoryRequestStatus;

class GetOrderHistoryRequest extends JsonSerializableType
{
    /**
     * @var ?string $market Trading pair to filter by. Format: `BASE_QUOTE` (e.g., `BTC_USDT`). Omit to retrieve orders across all markets.
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?string $clientOrderId Look up a specific order by the custom client identifier. When supplied, the endpoint switches to single-order lookup mode and the `startDate`, `endDate`, and `status` filters are ignored. Returns `422` with `"OrderHistory was not found."` if no order matches. Ignored when `orderId` is also provided.
     */
    #[JsonProperty('clientOrderId')]
    public ?string $clientOrderId;

    /**
     * @var ?int $orderId Look up a specific order by the exchange-assigned identifier. When supplied, the endpoint switches to single-order lookup mode and the `startDate`, `endDate`, and `status` filters are ignored. Returns an empty result on no match (no `422`). Takes precedence over `clientOrderId` when both are supplied.
     */
    #[JsonProperty('orderId')]
    public ?int $orderId;

    /**
     * @var ?value-of<GetOrderHistoryRequestStatus> $status Filter list-mode results by order status. Ignored when `orderId` or `clientOrderId` is supplied.
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var ?int $startDate Start of the query window as a Unix timestamp in seconds. Default: `now - 1 month`. The earliest reachable date is 6 months ago (00:00 UTC) — requests with an older `startDate` are rejected with a validation error.
     */
    #[JsonProperty('startDate')]
    public ?int $startDate;

    /**
     * @var ?int $endDate End of the query window as a Unix timestamp in seconds. Default: `now`. Values greater than the current time are silently clamped to `now`. The maximum span between `startDate` and `endDate` is 31 days.
     */
    #[JsonProperty('endDate')]
    public ?int $endDate;

    /**
     * @var ?int $offset Number of records to skip. Default: `0`.
     */
    #[JsonProperty('offset')]
    public ?int $offset;

    /**
     * @var ?int $limit Maximum number of records to return. Default: `50`. Minimum: `1`. Maximum: `500`.
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
     *   clientOrderId?: ?string,
     *   orderId?: ?int,
     *   status?: ?value-of<GetOrderHistoryRequestStatus>,
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
        $this->clientOrderId = $values['clientOrderId'] ?? null;
        $this->orderId = $values['orderId'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->startDate = $values['startDate'] ?? null;
        $this->endDate = $values['endDate'] ?? null;
        $this->offset = $values['offset'] ?? null;
        $this->limit = $values['limit'] ?? null;
        $this->request = $values['request'] ?? null;
        $this->nonce = $values['nonce'] ?? null;
    }
}

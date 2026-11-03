<?php

namespace Whitebit\SpotTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetExecutedOrderHistoryRequest extends JsonSerializableType
{
    /**
     * @var ?string $market Requested [market](/glossary#market). Example: BTC_USDT
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?string $clientOrderId Look up by custom client order identifier. When supplied, the endpoint switches to single-order lookup mode and returns the matching order's deal history. Returns `422` with `"OrderHistory was not found."` if no order matches on the calling account.
     */
    #[JsonProperty('clientOrderId')]
    public ?string $clientOrderId;

    /**
     * @var ?int $startDate Start date in Unix-time format
     */
    #[JsonProperty('startDate')]
    public ?int $startDate;

    /**
     * @var ?int $endDate End date in Unix-time format
     */
    #[JsonProperty('endDate')]
    public ?int $endDate;

    /**
     * @var ?int $offset Starting line index (OFFSET). Default: 0, Min: 0
     */
    #[JsonProperty('offset')]
    public ?int $offset;

    /**
     * @var ?int $limit LIMIT is a special clause used to limit records a particular query can return. Default: 50, Min: 1, Max: 500
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
        $this->startDate = $values['startDate'] ?? null;
        $this->endDate = $values['endDate'] ?? null;
        $this->offset = $values['offset'] ?? null;
        $this->limit = $values['limit'] ?? null;
        $this->request = $values['request'] ?? null;
        $this->nonce = $values['nonce'] ?? null;
    }
}

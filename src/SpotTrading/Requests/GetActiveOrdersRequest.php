<?php

namespace Whitebit\SpotTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetActiveOrdersRequest extends JsonSerializableType
{
    /**
     * @var ?string $market Trading pair to filter by. Format: `BASE_QUOTE` (e.g., `BTC_USDT`). Omit to retrieve orders across all markets.
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?int $orderId Filter by a specific order identifier. Returns only the matching active order.
     */
    #[JsonProperty('orderId')]
    public ?int $orderId;

    /**
     * @var ?string $clientOrderId Filter by custom client order identifier. Returns only the matching active order.
     */
    #[JsonProperty('clientOrderId')]
    public ?string $clientOrderId;

    /**
     * @var ?int $offset Number of records to skip. Default: `0`. Maximum: `4294967295`.
     */
    #[JsonProperty('offset')]
    public ?int $offset;

    /**
     * @var ?int $limit Maximum number of records to return. Default: `50`. Minimum: `1`. Maximum: `100`.
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
     *   orderId?: ?int,
     *   clientOrderId?: ?string,
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
        $this->orderId = $values['orderId'] ?? null;
        $this->clientOrderId = $values['clientOrderId'] ?? null;
        $this->offset = $values['offset'] ?? null;
        $this->limit = $values['limit'] ?? null;
        $this->request = $values['request'] ?? null;
        $this->nonce = $values['nonce'] ?? null;
    }
}

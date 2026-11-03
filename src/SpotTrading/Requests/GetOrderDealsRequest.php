<?php

namespace Whitebit\SpotTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetOrderDealsRequest extends JsonSerializableType
{
    /**
     * @var int $orderId Identifier of the order to retrieve deals for.
     */
    #[JsonProperty('orderId')]
    public int $orderId;

    /**
     * @var ?int $offset Number of records to skip. Default: `0`.
     */
    #[JsonProperty('offset')]
    public ?int $offset;

    /**
     * @var ?int $limit Maximum number of records to return. Default: `50`.
     */
    #[JsonProperty('limit')]
    public ?int $limit;

    /**
     * @var string $request
     */
    #[JsonProperty('request')]
    public string $request;

    /**
     * @var int $nonce
     */
    #[JsonProperty('nonce')]
    public int $nonce;

    /**
     * @param array{
     *   orderId: int,
     *   request: string,
     *   nonce: int,
     *   offset?: ?int,
     *   limit?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->orderId = $values['orderId'];
        $this->offset = $values['offset'] ?? null;
        $this->limit = $values['limit'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

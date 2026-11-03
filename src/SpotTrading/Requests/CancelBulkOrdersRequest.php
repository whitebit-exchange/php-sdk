<?php

namespace Whitebit\SpotTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Types\BulkCancelOrderItem;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class CancelBulkOrdersRequest extends JsonSerializableType
{
    /**
     * @var array<BulkCancelOrderItem> $orders Array of orders to cancel. From 1 to 100 items per request.
     */
    #[JsonProperty('orders'), ArrayType([BulkCancelOrderItem::class])]
    public array $orders;

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
     *   orders: array<BulkCancelOrderItem>,
     *   request: string,
     *   nonce: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->orders = $values['orders'];
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

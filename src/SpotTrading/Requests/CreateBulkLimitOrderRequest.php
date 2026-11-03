<?php

namespace Whitebit\SpotTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Types\BulkOrderItem;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class CreateBulkLimitOrderRequest extends JsonSerializableType
{
    /**
     * @var array<BulkOrderItem> $orders Array of limit orders. Each item is validated with the same rules as a single limit order.
     */
    #[JsonProperty('orders'), ArrayType([BulkOrderItem::class])]
    public array $orders;

    /**
     * Controls how the bulk order processor handles failures.
     *
     * When true: Processing stops at the first order that fails validation or execution. Only orders up to (but not including) the failed order are processed.
     *
     * When false (default): All orders in the bulk request are processed regardless of individual failures. Each order result is returned in the response array.
     *
     * @var ?bool $stopOnFail
     */
    #[JsonProperty('stopOnFail')]
    public ?bool $stopOnFail;

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
     *   orders: array<BulkOrderItem>,
     *   request: string,
     *   nonce: int,
     *   stopOnFail?: ?bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->orders = $values['orders'];
        $this->stopOnFail = $values['stopOnFail'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

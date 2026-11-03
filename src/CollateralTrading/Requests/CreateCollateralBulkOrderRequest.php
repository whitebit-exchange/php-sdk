<?php

namespace Whitebit\CollateralTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\CollateralTrading\Types\CreateCollateralBulkOrderRequestOrdersItem;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class CreateCollateralBulkOrderRequest extends JsonSerializableType
{
    /**
     * @var ?array<CreateCollateralBulkOrderRequestOrdersItem> $orders
     */
    #[JsonProperty('orders'), ArrayType([CreateCollateralBulkOrderRequestOrdersItem::class])]
    public ?array $orders;

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
     *   orders?: ?array<CreateCollateralBulkOrderRequestOrdersItem>,
     *   stopOnFail?: ?bool,
     *   request?: ?string,
     *   nonce?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->orders = $values['orders'] ?? null;
        $this->stopOnFail = $values['stopOnFail'] ?? null;
        $this->request = $values['request'] ?? null;
        $this->nonce = $values['nonce'] ?? null;
    }
}

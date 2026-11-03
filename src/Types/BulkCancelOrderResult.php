<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Acknowledgement that a single item was cancelled. The endpoint echoes the identifiers from the request item; full order state is not returned. Use the single Cancel order endpoint when post-cancel order state is required.
 */
class BulkCancelOrderResult extends JsonSerializableType
{
    /**
     * @var ?int $orderId System-assigned order ID of the cancelled order.
     */
    #[JsonProperty('orderId')]
    public ?int $orderId;

    /**
     * @var ?string $clientOrderId Client-defined order ID of the cancelled order, if one was set at order creation.
     */
    #[JsonProperty('clientOrderId')]
    public ?string $clientOrderId;

    /**
     * @var ?string $market Trading pair of the cancelled order. Format: `BASE_QUOTE` (e.g. `BTC_USDT`).
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @param array{
     *   orderId?: ?int,
     *   clientOrderId?: ?string,
     *   market?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->orderId = $values['orderId'] ?? null;
        $this->clientOrderId = $values['clientOrderId'] ?? null;
        $this->market = $values['market'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

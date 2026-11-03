<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * A single cancel target. Provide `market` and exactly one of `orderId` or `clientOrderId`. Sending both, or neither, returns a per-item validation error.
 */
class BulkCancelOrderItem extends JsonSerializableType
{
    /**
     * @var string $market Available [market](/glossary#market). Example: `BTC_USDT`.
     */
    #[JsonProperty('market')]
    public string $market;

    /**
     * @var ?int $orderId System-assigned order ID. Required if `clientOrderId` is not set; mutually exclusive with `clientOrderId`.
     */
    #[JsonProperty('orderId')]
    public ?int $orderId;

    /**
     * @var ?string $clientOrderId Client-defined order ID supplied at order creation. Required if `orderId` is not set; mutually exclusive with `orderId`.
     */
    #[JsonProperty('clientOrderId')]
    public ?string $clientOrderId;

    /**
     * @param array{
     *   market: string,
     *   orderId?: ?int,
     *   clientOrderId?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->market = $values['market'];
        $this->orderId = $values['orderId'] ?? null;
        $this->clientOrderId = $values['clientOrderId'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

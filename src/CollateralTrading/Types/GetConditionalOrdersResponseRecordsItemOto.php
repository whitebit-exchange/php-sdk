<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Types\OrderResponse;

/**
 * OTO type conditional order
 */
class GetConditionalOrdersResponseRecordsItemOto extends JsonSerializableType
{
    /**
     * @var ?int $id Conditional order identifier
     */
    #[JsonProperty('id')]
    public ?int $id;

    /**
     * @var ?string $conditionalOrderType Conditional order subtype. Omitted when not set.
     */
    #[JsonProperty('conditionalOrderType')]
    public ?string $conditionalOrderType;

    /**
     * @var ?string $stopLossPrice Stop loss order price
     */
    #[JsonProperty('stopLossPrice')]
    public ?string $stopLossPrice;

    /**
     * @var ?string $takeProfitPrice Take profit order price
     */
    #[JsonProperty('takeProfitPrice')]
    public ?string $takeProfitPrice;

    /**
     * @var ?OrderResponse $conditionalOrder The linked active order. Same shape as an `/api/v4/orders` record, including its per-order `reduceOnly` flag.
     */
    #[JsonProperty('conditionalOrder')]
    public ?OrderResponse $conditionalOrder;

    /**
     * @param array{
     *   id?: ?int,
     *   conditionalOrderType?: ?string,
     *   stopLossPrice?: ?string,
     *   takeProfitPrice?: ?string,
     *   conditionalOrder?: ?OrderResponse,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->id = $values['id'] ?? null;
        $this->conditionalOrderType = $values['conditionalOrderType'] ?? null;
        $this->stopLossPrice = $values['stopLossPrice'] ?? null;
        $this->takeProfitPrice = $values['takeProfitPrice'] ?? null;
        $this->conditionalOrder = $values['conditionalOrder'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

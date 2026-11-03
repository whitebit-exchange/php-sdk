<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Types\OcoOrderLeg;

class GetOcoOrdersResponseItem extends JsonSerializableType
{
    /**
     * @var ?int $id OCO order identifier
     */
    #[JsonProperty('id')]
    public ?int $id;

    /**
     * @var ?OcoOrderLeg $stopLoss Stop loss order details. Includes the `activation_price` / `activation_condition` / `activated` trigger fields.
     */
    #[JsonProperty('stop_loss')]
    public ?OcoOrderLeg $stopLoss;

    /**
     * @var ?OcoOrderLeg $takeProfit Take profit order details. The trigger fields are omitted on this leg.
     */
    #[JsonProperty('take_profit')]
    public ?OcoOrderLeg $takeProfit;

    /**
     * @param array{
     *   id?: ?int,
     *   stopLoss?: ?OcoOrderLeg,
     *   takeProfit?: ?OcoOrderLeg,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->id = $values['id'] ?? null;
        $this->stopLoss = $values['stopLoss'] ?? null;
        $this->takeProfit = $values['takeProfit'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

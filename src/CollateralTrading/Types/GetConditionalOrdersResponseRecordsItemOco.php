<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Types\ConditionalOrderLeg;

/**
 * OCO type conditional order
 */
class GetConditionalOrdersResponseRecordsItemOco extends JsonSerializableType
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
     * @var ?ConditionalOrderLeg $stopLoss Stop-loss leg of the OCO order. The `reduceOnly` flag is returned per leg.
     */
    #[JsonProperty('stopLoss')]
    public ?ConditionalOrderLeg $stopLoss;

    /**
     * @var ?ConditionalOrderLeg $takeProfit Take-profit leg of the OCO order. The `reduceOnly` flag is returned per leg.
     */
    #[JsonProperty('takeProfit')]
    public ?ConditionalOrderLeg $takeProfit;

    /**
     * @param array{
     *   id?: ?int,
     *   conditionalOrderType?: ?string,
     *   stopLoss?: ?ConditionalOrderLeg,
     *   takeProfit?: ?ConditionalOrderLeg,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->id = $values['id'] ?? null;
        $this->conditionalOrderType = $values['conditionalOrderType'] ?? null;
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

<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CreateCollateralOcoOrderResponse extends JsonSerializableType
{
    /**
     * @var ?int $id OCO order identifier
     */
    #[JsonProperty('id')]
    public ?int $id;

    /**
     * @var ?bool $reduceOnly Reduce-only flag
     */
    #[JsonProperty('reduceOnly')]
    public ?bool $reduceOnly;

    /**
     * @var ?CreateCollateralOcoOrderResponseStopLoss $stopLoss Stop loss order details
     */
    #[JsonProperty('stop_loss')]
    public ?CreateCollateralOcoOrderResponseStopLoss $stopLoss;

    /**
     * @var ?CreateCollateralOcoOrderResponseTakeProfit $takeProfit Take profit order details
     */
    #[JsonProperty('take_profit')]
    public ?CreateCollateralOcoOrderResponseTakeProfit $takeProfit;

    /**
     * @param array{
     *   id?: ?int,
     *   reduceOnly?: ?bool,
     *   stopLoss?: ?CreateCollateralOcoOrderResponseStopLoss,
     *   takeProfit?: ?CreateCollateralOcoOrderResponseTakeProfit,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->id = $values['id'] ?? null;
        $this->reduceOnly = $values['reduceOnly'] ?? null;
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

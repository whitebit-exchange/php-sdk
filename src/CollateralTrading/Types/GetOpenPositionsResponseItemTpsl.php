<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Take profit and stop loss configuration
 */
class GetOpenPositionsResponseItemTpsl extends JsonSerializableType
{
    /**
     * @var ?int $takeProfitId Take profit order ID
     */
    #[JsonProperty('takeProfitId')]
    public ?int $takeProfitId;

    /**
     * @var ?string $takeProfit Take profit price
     */
    #[JsonProperty('takeProfit')]
    public ?string $takeProfit;

    /**
     * @var ?int $stopLossId Stop loss order ID
     */
    #[JsonProperty('stopLossId')]
    public ?int $stopLossId;

    /**
     * @var ?string $stopLoss Stop loss price
     */
    #[JsonProperty('stopLoss')]
    public ?string $stopLoss;

    /**
     * @param array{
     *   takeProfitId?: ?int,
     *   takeProfit?: ?string,
     *   stopLossId?: ?int,
     *   stopLoss?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->takeProfitId = $values['takeProfitId'] ?? null;
        $this->takeProfit = $values['takeProfit'] ?? null;
        $this->stopLossId = $values['stopLossId'] ?? null;
        $this->stopLoss = $values['stopLoss'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

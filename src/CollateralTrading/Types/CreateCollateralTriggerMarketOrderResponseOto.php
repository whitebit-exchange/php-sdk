<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * OTO order data when stopLoss or takeProfit is specified
 */
class CreateCollateralTriggerMarketOrderResponseOto extends JsonSerializableType
{
    /**
     * @var ?int $otoId OTO order identifier
     */
    #[JsonProperty('otoId')]
    public ?int $otoId;

    /**
     * @var ?string $stopLoss Stop loss order price
     */
    #[JsonProperty('stopLoss')]
    public ?string $stopLoss;

    /**
     * @var ?string $takeProfit Take profit order price
     */
    #[JsonProperty('takeProfit')]
    public ?string $takeProfit;

    /**
     * @param array{
     *   otoId?: ?int,
     *   stopLoss?: ?string,
     *   takeProfit?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->otoId = $values['otoId'] ?? null;
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

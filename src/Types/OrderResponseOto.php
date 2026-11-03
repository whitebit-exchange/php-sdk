<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * OTO order data. Present only when the order belongs to an [OTO](/glossary#one-triggers-the-other-oto) group — returned on the cancel, active-orders list, and modify responses.
 */
class OrderResponseOto extends JsonSerializableType
{
    /**
     * @var ?int $otoId OTO order identifier
     */
    #[JsonProperty('otoId')]
    public ?int $otoId;

    /**
     * @var ?string $takeProfit Take profit order price
     */
    #[JsonProperty('takeProfit')]
    public ?string $takeProfit;

    /**
     * @var ?string $stopLoss Stop loss order price
     */
    #[JsonProperty('stopLoss')]
    public ?string $stopLoss;

    /**
     * @param array{
     *   otoId?: ?int,
     *   takeProfit?: ?string,
     *   stopLoss?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->otoId = $values['otoId'] ?? null;
        $this->takeProfit = $values['takeProfit'] ?? null;
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

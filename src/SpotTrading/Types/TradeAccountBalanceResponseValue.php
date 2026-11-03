<?php

namespace Whitebit\SpotTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class TradeAccountBalanceResponseValue extends JsonSerializableType
{
    /**
     * @var ?string $available Available balance of currency for trading
     */
    #[JsonProperty('available')]
    public ?string $available;

    /**
     * @var ?string $freeze Balance of currency that is currently in active orders
     */
    #[JsonProperty('freeze')]
    public ?string $freeze;

    /**
     * @param array{
     *   available?: ?string,
     *   freeze?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->available = $values['available'] ?? null;
        $this->freeze = $values['freeze'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

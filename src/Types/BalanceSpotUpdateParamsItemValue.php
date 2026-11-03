<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class BalanceSpotUpdateParamsItemValue extends JsonSerializableType
{
    /**
     * @var ?string $available Amount available for trade
     */
    #[JsonProperty('available')]
    public ?string $available;

    /**
     * @var ?string $freeze Amount in active [orders](/glossary#orders)
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

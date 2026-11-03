<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetCollateralHedgeModeResponse extends JsonSerializableType
{
    /**
     * @var ?bool $hedgeMode Indicates whether hedge mode is active. When `true`, the account supports simultaneous long and short positions on the same market.
     */
    #[JsonProperty('hedgeMode')]
    public ?bool $hedgeMode;

    /**
     * @param array{
     *   hedgeMode?: ?bool,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->hedgeMode = $values['hedgeMode'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

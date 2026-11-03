<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class ChangeCollateralAccountLeverageResponse extends JsonSerializableType
{
    /**
     * @var ?int $leverage Active leverage level for the collateral account after the update, from `1` (no leverage) to `100`
     */
    #[JsonProperty('leverage')]
    public ?int $leverage;

    /**
     * @param array{
     *   leverage?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->leverage = $values['leverage'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

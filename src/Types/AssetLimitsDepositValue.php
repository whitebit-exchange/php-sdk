<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class AssetLimitsDepositValue extends JsonSerializableType
{
    /**
     * @var ?string $min
     */
    #[JsonProperty('min')]
    public ?string $min;

    /**
     * @var ?string $max
     */
    #[JsonProperty('max')]
    public ?string $max;

    /**
     * @param array{
     *   min?: ?string,
     *   max?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->min = $values['min'] ?? null;
        $this->max = $values['max'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

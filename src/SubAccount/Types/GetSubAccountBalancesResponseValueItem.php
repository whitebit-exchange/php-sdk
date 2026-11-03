<?php

namespace Whitebit\SubAccount\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetSubAccountBalancesResponseValueItem extends JsonSerializableType
{
    /**
     * @var ?string $main
     */
    #[JsonProperty('main')]
    public ?string $main;

    /**
     * @var ?string $spot
     */
    #[JsonProperty('spot')]
    public ?string $spot;

    /**
     * @var ?string $collateral
     */
    #[JsonProperty('collateral')]
    public ?string $collateral;

    /**
     * @param array{
     *   main?: ?string,
     *   spot?: ?string,
     *   collateral?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->main = $values['main'] ?? null;
        $this->spot = $values['spot'] ?? null;
        $this->collateral = $values['collateral'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

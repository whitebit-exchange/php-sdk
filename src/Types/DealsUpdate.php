<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class DealsUpdate extends JsonSerializableType
{
    /**
     * @var mixed $id Update events have null id
     */
    #[JsonProperty('id')]
    public mixed $id;

    /**
     * @var value-of<DealsUpdateMethod> $method Method name. Fixed value: `deals_update`.
     */
    #[JsonProperty('method')]
    public string $method;

    /**
     * Update event tuple (11 elements):
     * - [0] Deal ID
     * - [1] Deal time (Unix timestamp)
     * - [2] Market
     * - [3] Order ID
     * - [4] Price
     * - [5] Stock amount
     * - [6] Deal fee
     * - [7] Client order ID
     * - [8] Side (1=sell, 2=buy)
     * - [9] Role (1=maker, 2=taker)
     * - [10] Fee asset
     *
     * @var array<mixed> $params
     */
    #[JsonProperty('params'), ArrayType(['mixed'])]
    public array $params;

    /**
     * @param array{
     *   method: value-of<DealsUpdateMethod>,
     *   params: array<mixed>,
     *   id?: mixed,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'] ?? null;
        $this->method = $values['method'];
        $this->params = $values['params'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

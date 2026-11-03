<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class MarketUpdate extends JsonSerializableType
{
    /**
     * @var mixed $id
     */
    #[JsonProperty('id')]
    public mixed $id;

    /**
     * @var value-of<MarketUpdateMethod> $method Method name. Fixed value: `market_update`.
     */
    #[JsonProperty('method')]
    public string $method;

    /**
     * Update event parameters:
     * - [0] Market name
     * - [1] MarketStatistics object
     *
     * @var array<mixed> $params
     */
    #[JsonProperty('params'), ArrayType(['mixed'])]
    public array $params;

    /**
     * @param array{
     *   method: value-of<MarketUpdateMethod>,
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

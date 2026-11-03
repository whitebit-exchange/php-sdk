<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class DepthSubscribe extends JsonSerializableType
{
    /**
     * @var int $id
     */
    #[JsonProperty('id')]
    public int $id;

    /**
     * @var value-of<DepthSubscribeMethod> $method Method name. Fixed value: `depth_subscribe`.
     */
    #[JsonProperty('method')]
    public string $method;

    /**
     * Subscription parameters:
     * - [0] Market name
     * - [1] Limit (1, 5, 10, 20, 30, 50, or 100)
     * - [2] Price interval units
     * - [3] Multiple subscription flag (true=add, false=unsubscribe all)
     *
     * @var array<mixed> $params
     */
    #[JsonProperty('params'), ArrayType(['mixed'])]
    public array $params;

    /**
     * @param array{
     *   id: int,
     *   method: value-of<DepthSubscribeMethod>,
     *   params: array<mixed>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'];
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

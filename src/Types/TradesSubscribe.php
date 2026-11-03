<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class TradesSubscribe extends JsonSerializableType
{
    /**
     * @var int $id
     */
    #[JsonProperty('id')]
    public int $id;

    /**
     * @var value-of<TradesSubscribeMethod> $method Method name. Fixed value: `trades_subscribe`.
     */
    #[JsonProperty('method')]
    public string $method;

    /**
     * @var array<string> $params Market names (empty array to subscribe to all markets)
     */
    #[JsonProperty('params'), ArrayType(['string'])]
    public array $params;

    /**
     * @param array{
     *   id: int,
     *   method: value-of<TradesSubscribeMethod>,
     *   params: array<string>,
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

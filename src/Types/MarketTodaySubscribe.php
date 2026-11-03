<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class MarketTodaySubscribe extends JsonSerializableType
{
    /**
     * @var int $id
     */
    #[JsonProperty('id')]
    public int $id;

    /**
     * @var value-of<MarketTodaySubscribeMethod> $method Method name. Fixed value: `marketToday_subscribe`.
     */
    #[JsonProperty('method')]
    public string $method;

    /**
     * @var array<string> $params
     */
    #[JsonProperty('params'), ArrayType(['string'])]
    public array $params;

    /**
     * @param array{
     *   id: int,
     *   method: value-of<MarketTodaySubscribeMethod>,
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

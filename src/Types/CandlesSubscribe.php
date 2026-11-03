<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class CandlesSubscribe extends JsonSerializableType
{
    /**
     * @var int $id Unique request identifier
     */
    #[JsonProperty('id')]
    public int $id;

    /**
     * @var value-of<CandlesSubscribeMethod> $method Method name. Fixed value: `candles_subscribe`.
     */
    #[JsonProperty('method')]
    public string $method;

    /**
     * Subscription parameters:
     * - [0] Market name (e.g., BTC_USD)
     * - [1] Interval in seconds
     *
     * @var array<mixed> $params
     */
    #[JsonProperty('params'), ArrayType(['mixed'])]
    public array $params;

    /**
     * @param array{
     *   id: int,
     *   method: value-of<CandlesSubscribeMethod>,
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

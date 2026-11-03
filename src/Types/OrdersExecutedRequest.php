<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class OrdersExecutedRequest extends JsonSerializableType
{
    /**
     * @var int $id Unique request identifier
     */
    #[JsonProperty('id')]
    public int $id;

    /**
     * @var value-of<OrdersExecutedRequestMethod> $method Method name. Fixed value: `ordersExecuted_request`.
     */
    #[JsonProperty('method')]
    public string $method;

    /**
     * Query parameters tuple:
     * - [0] Filter object with market and order_types
     * - [1] Offset
     * - [2] Limit (max 100)
     *
     * @var array<mixed> $params
     */
    #[JsonProperty('params'), ArrayType(['mixed'])]
    public array $params;

    /**
     * @param array{
     *   id: int,
     *   method: value-of<OrdersExecutedRequestMethod>,
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

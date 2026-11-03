<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class OrdersExecutedUpdate extends JsonSerializableType
{
    /**
     * @var mixed $id Update events have null id
     */
    #[JsonProperty('id')]
    public mixed $id;

    /**
     * @var value-of<OrdersExecutedUpdateMethod> $method Method name. Fixed value: `ordersExecuted_update`.
     */
    #[JsonProperty('method')]
    public string $method;

    /**
     * @var array<ExecutedOrderObject> $params Array containing executed order object
     */
    #[JsonProperty('params'), ArrayType([ExecutedOrderObject::class])]
    public array $params;

    /**
     * @param array{
     *   method: value-of<OrdersExecutedUpdateMethod>,
     *   params: array<ExecutedOrderObject>,
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

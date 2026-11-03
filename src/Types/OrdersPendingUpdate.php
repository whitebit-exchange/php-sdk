<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class OrdersPendingUpdate extends JsonSerializableType
{
    /**
     * @var mixed $id Update events have null id
     */
    #[JsonProperty('id')]
    public mixed $id;

    /**
     * @var value-of<OrdersPendingUpdateMethod> $method Method name. Fixed value: `ordersPending_update`.
     */
    #[JsonProperty('method')]
    public string $method;

    /**
     * @var array<mixed> $params Array with update event ID and order object
     */
    #[JsonProperty('params'), ArrayType(['mixed'])]
    public array $params;

    /**
     * @param array{
     *   method: value-of<OrdersPendingUpdateMethod>,
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

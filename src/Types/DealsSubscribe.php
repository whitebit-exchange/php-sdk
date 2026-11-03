<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class DealsSubscribe extends JsonSerializableType
{
    /**
     * @var int $id Unique request identifier
     */
    #[JsonProperty('id')]
    public int $id;

    /**
     * @var value-of<DealsSubscribeMethod> $method Method name. Fixed value: `deals_subscribe`.
     */
    #[JsonProperty('method')]
    public string $method;

    /**
     * @var array<array<string>> $params Array containing array of markets
     */
    #[JsonProperty('params'), ArrayType([['string']])]
    public array $params;

    /**
     * @param array{
     *   id: int,
     *   method: value-of<DealsSubscribeMethod>,
     *   params: array<array<string>>,
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

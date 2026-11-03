<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class PositionsUpdate extends JsonSerializableType
{
    /**
     * @var mixed $id Update events have null id
     */
    #[JsonProperty('id')]
    public mixed $id;

    /**
     * @var value-of<PositionsUpdateMethod> $method Method name. Fixed value: `positionsMargin_update`.
     */
    #[JsonProperty('method')]
    public string $method;

    /**
     * @var PositionsUpdateParams $params
     */
    #[JsonProperty('params')]
    public PositionsUpdateParams $params;

    /**
     * @param array{
     *   method: value-of<PositionsUpdateMethod>,
     *   params: PositionsUpdateParams,
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

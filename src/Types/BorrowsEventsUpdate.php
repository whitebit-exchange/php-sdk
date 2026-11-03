<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class BorrowsEventsUpdate extends JsonSerializableType
{
    /**
     * @var mixed $id Update events have null id
     */
    #[JsonProperty('id')]
    public mixed $id;

    /**
     * @var value-of<BorrowsEventsUpdateMethod> $method Method name. Fixed value: `borrowsAccountMargin_update`.
     */
    #[JsonProperty('method')]
    public string $method;

    /**
     * Event tuple:
     * - [0] Event type (1=Margin call, 2=Liquidation)
     * - [1] Borrow object with all borrow details
     *
     * @var array<mixed> $params
     */
    #[JsonProperty('params'), ArrayType(['mixed'])]
    public array $params;

    /**
     * @param array{
     *   method: value-of<BorrowsEventsUpdateMethod>,
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

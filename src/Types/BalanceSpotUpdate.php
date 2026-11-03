<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class BalanceSpotUpdate extends JsonSerializableType
{
    /**
     * @var mixed $id Update events have null id
     */
    #[JsonProperty('id')]
    public mixed $id;

    /**
     * @var value-of<BalanceSpotUpdateMethod> $method Method name. Fixed value: `balanceSpot_update`.
     */
    #[JsonProperty('method')]
    public string $method;

    /**
     * @var array<array<string, BalanceSpotUpdateParamsItemValue>> $params Array containing balance updates for subscribed assets
     */
    #[JsonProperty('params'), ArrayType([['string' => BalanceSpotUpdateParamsItemValue::class]])]
    public array $params;

    /**
     * @param array{
     *   method: value-of<BalanceSpotUpdateMethod>,
     *   params: array<array<string, BalanceSpotUpdateParamsItemValue>>,
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

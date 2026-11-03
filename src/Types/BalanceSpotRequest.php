<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class BalanceSpotRequest extends JsonSerializableType
{
    /**
     * @var int $id Unique request identifier
     */
    #[JsonProperty('id')]
    public int $id;

    /**
     * @var value-of<BalanceSpotRequestMethod> $method Method name. Fixed value: `balanceSpot_request`.
     */
    #[JsonProperty('method')]
    public string $method;

    /**
     * @var array<string> $params Array of asset tickers to query. Empty array returns all balances.
     */
    #[JsonProperty('params'), ArrayType(['string'])]
    public array $params;

    /**
     * @param array{
     *   id: int,
     *   method: value-of<BalanceSpotRequestMethod>,
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

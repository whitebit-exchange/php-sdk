<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class BalanceMarginRequest extends JsonSerializableType
{
    /**
     * @var int $id Unique request identifier
     */
    #[JsonProperty('id')]
    public int $id;

    /**
     * @var value-of<BalanceMarginRequestMethod> $method Method name. Fixed value: `balanceMargin_request`.
     */
    #[JsonProperty('method')]
    public string $method;

    /**
     * @var array<string> $params Array of asset tickers to query
     */
    #[JsonProperty('params'), ArrayType(['string'])]
    public array $params;

    /**
     * @param array{
     *   id: int,
     *   method: value-of<BalanceMarginRequestMethod>,
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

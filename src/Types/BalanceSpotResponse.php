<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class BalanceSpotResponse extends JsonSerializableType
{
    /**
     * @var int $id Request identifier matching the request
     */
    #[JsonProperty('id')]
    public int $id;

    /**
     * @var array<string, BalanceSpotResponseResultValue> $result Wallet balances by currency
     */
    #[JsonProperty('result'), ArrayType(['string' => BalanceSpotResponseResultValue::class])]
    public array $result;

    /**
     * @var mixed $error Error object (null on success)
     */
    #[JsonProperty('error')]
    public mixed $error;

    /**
     * @param array{
     *   id: int,
     *   result: array<string, BalanceSpotResponseResultValue>,
     *   error?: mixed,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'];
        $this->result = $values['result'];
        $this->error = $values['error'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

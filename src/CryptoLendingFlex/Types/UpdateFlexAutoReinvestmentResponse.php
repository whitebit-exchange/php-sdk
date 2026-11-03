<?php

namespace Whitebit\CryptoLendingFlex\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class UpdateFlexAutoReinvestmentResponse extends JsonSerializableType
{
    /**
     * @var ?array<mixed> $data
     */
    #[JsonProperty('data'), ArrayType(['mixed'])]
    public ?array $data;

    /**
     * @param array{
     *   data?: ?array<mixed>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->data = $values['data'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

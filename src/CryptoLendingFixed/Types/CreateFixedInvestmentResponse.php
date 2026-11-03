<?php

namespace Whitebit\CryptoLendingFixed\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CreateFixedInvestmentResponse extends JsonSerializableType
{
    /**
     * @var ?string $id Investment identifier
     */
    #[JsonProperty('id')]
    public ?string $id;

    /**
     * @param array{
     *   id?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->id = $values['id'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

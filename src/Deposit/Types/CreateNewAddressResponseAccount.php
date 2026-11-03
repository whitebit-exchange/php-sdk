<?php

namespace Whitebit\Deposit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CreateNewAddressResponseAccount extends JsonSerializableType
{
    /**
     * @var ?string $address Deposit address
     */
    #[JsonProperty('address')]
    public ?string $address;

    /**
     * @var ?string $memo Memo if currency requires memo
     */
    #[JsonProperty('memo')]
    public ?string $memo;

    /**
     * @param array{
     *   address?: ?string,
     *   memo?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->address = $values['address'] ?? null;
        $this->memo = $values['memo'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

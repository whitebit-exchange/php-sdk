<?php

namespace Whitebit\Deposit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CreateNewAddressResponse extends JsonSerializableType
{
    /**
     * @var ?CreateNewAddressResponseAccount $account
     */
    #[JsonProperty('account')]
    public ?CreateNewAddressResponseAccount $account;

    /**
     * @var ?CreateNewAddressResponseRequired $required
     */
    #[JsonProperty('required')]
    public ?CreateNewAddressResponseRequired $required;

    /**
     * @param array{
     *   account?: ?CreateNewAddressResponseAccount,
     *   required?: ?CreateNewAddressResponseRequired,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->account = $values['account'] ?? null;
        $this->required = $values['required'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

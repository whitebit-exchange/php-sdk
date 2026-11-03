<?php

namespace Whitebit\Deposit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetDepositAddressResponse extends JsonSerializableType
{
    /**
     * @var ?GetDepositAddressResponseAccount $account
     */
    #[JsonProperty('account')]
    public ?GetDepositAddressResponseAccount $account;

    /**
     * @var ?GetDepositAddressResponseRequired $required
     */
    #[JsonProperty('required')]
    public ?GetDepositAddressResponseRequired $required;

    /**
     * @param array{
     *   account?: ?GetDepositAddressResponseAccount,
     *   required?: ?GetDepositAddressResponseRequired,
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

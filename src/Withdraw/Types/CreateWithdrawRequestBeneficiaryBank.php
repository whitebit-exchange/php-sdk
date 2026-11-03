<?php

namespace Whitebit\Withdraw\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Beneficiary bank details for bank-rail withdrawals (used when the destination is an account number rather than an IBAN).
 */
class CreateWithdrawRequestBeneficiaryBank extends JsonSerializableType
{
    /**
     * @var ?string $routingNumber Bank routing number (ABA, BSB, sort code, or equivalent for the destination country).
     */
    #[JsonProperty('routingNumber')]
    public ?string $routingNumber;

    /**
     * @var ?string $name Bank name.
     */
    #[JsonProperty('name')]
    public ?string $name;

    /**
     * @var ?string $address Bank postal address.
     */
    #[JsonProperty('address')]
    public ?string $address;

    /**
     * @var ?string $country Bank country (ISO code).
     */
    #[JsonProperty('country')]
    public ?string $country;

    /**
     * @param array{
     *   routingNumber?: ?string,
     *   name?: ?string,
     *   address?: ?string,
     *   country?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->routingNumber = $values['routingNumber'] ?? null;
        $this->name = $values['name'] ?? null;
        $this->address = $values['address'] ?? null;
        $this->country = $values['country'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

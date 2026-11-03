<?php

namespace Whitebit\Withdraw\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Beneficiary information.
 */
class CreateWithdrawRequestTravelRuleBeneficiary extends JsonSerializableType
{
    /**
     * Beneficiary type:
     * - `individual` - Natural person. Requires `firstName`, `lastName`.
     * - `entity` - Legal entity. Requires `fullName`.
     *
     * @var ?value-of<CreateWithdrawRequestTravelRuleBeneficiaryType> $type
     */
    #[JsonProperty('type')]
    public ?string $type;

    /**
     * @var ?string $firstName First name. Required if `type` is `individual`.
     */
    #[JsonProperty('firstName')]
    public ?string $firstName;

    /**
     * @var ?string $lastName Last name. Required if `type` is `individual`.
     */
    #[JsonProperty('lastName')]
    public ?string $lastName;

    /**
     * @var ?string $fullName Full legal name. Required if `type` is `entity`.
     */
    #[JsonProperty('fullName')]
    public ?string $fullName;

    /**
     * @var ?string $residenceCountry Beneficiary's country of residence. ISO 3166-1 alpha-3 code (3 letters).
     */
    #[JsonProperty('residenceCountry')]
    public ?string $residenceCountry;

    /**
     * @var ?CreateWithdrawRequestTravelRuleBeneficiaryAddress $address Physical address.
     */
    #[JsonProperty('address')]
    public ?CreateWithdrawRequestTravelRuleBeneficiaryAddress $address;

    /**
     * @param array{
     *   type?: ?value-of<CreateWithdrawRequestTravelRuleBeneficiaryType>,
     *   firstName?: ?string,
     *   lastName?: ?string,
     *   fullName?: ?string,
     *   residenceCountry?: ?string,
     *   address?: ?CreateWithdrawRequestTravelRuleBeneficiaryAddress,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->type = $values['type'] ?? null;
        $this->firstName = $values['firstName'] ?? null;
        $this->lastName = $values['lastName'] ?? null;
        $this->fullName = $values['fullName'] ?? null;
        $this->residenceCountry = $values['residenceCountry'] ?? null;
        $this->address = $values['address'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

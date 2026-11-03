<?php

namespace Whitebit\Withdraw\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Physical address.
 */
class CreateWithdrawRequestTravelRuleBeneficiaryAddress extends JsonSerializableType
{
    /**
     * @var ?string $country ISO 3166-1 alpha-3 country code.
     */
    #[JsonProperty('country')]
    public ?string $country;

    /**
     * @var ?string $city City name.
     */
    #[JsonProperty('city')]
    public ?string $city;

    /**
     * @var ?string $postCode Postal code.
     */
    #[JsonProperty('postCode')]
    public ?string $postCode;

    /**
     * @var ?string $addressLine1 Street address.
     */
    #[JsonProperty('addressLine1')]
    public ?string $addressLine1;

    /**
     * @param array{
     *   country?: ?string,
     *   city?: ?string,
     *   postCode?: ?string,
     *   addressLine1?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->country = $values['country'] ?? null;
        $this->city = $values['city'] ?? null;
        $this->postCode = $values['postCode'] ?? null;
        $this->addressLine1 = $values['addressLine1'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

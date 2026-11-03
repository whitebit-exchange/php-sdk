<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Physical address for travel rule compliance
 */
class TravelRuleAddress extends JsonSerializableType
{
    /**
     * @var string $country ISO 3166-1 alpha-3 country code (3 letters)
     */
    #[JsonProperty('country')]
    public string $country;

    /**
     * @var string $city City name
     */
    #[JsonProperty('city')]
    public string $city;

    /**
     * @var ?string $postCode Postal code (optional)
     */
    #[JsonProperty('postCode')]
    public ?string $postCode;

    /**
     * @var string $addressLine1 Street address
     */
    #[JsonProperty('addressLine1')]
    public string $addressLine1;

    /**
     * @param array{
     *   country: string,
     *   city: string,
     *   addressLine1: string,
     *   postCode?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->country = $values['country'];
        $this->city = $values['city'];
        $this->postCode = $values['postCode'] ?? null;
        $this->addressLine1 = $values['addressLine1'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

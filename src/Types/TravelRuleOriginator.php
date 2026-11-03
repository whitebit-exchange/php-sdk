<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Originator information for travel rule compliance
 */
class TravelRuleOriginator extends JsonSerializableType
{
    /**
     * Party type:
     * - `individual` - Natural person. Requires `firstName` and `lastName`.
     * - `entity` - Legal entity. Requires `fullName`.
     *
     * @var value-of<TravelRuleOriginatorType> $type
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var ?string $firstName First name. Required if type = `individual`.
     */
    #[JsonProperty('firstName')]
    public ?string $firstName;

    /**
     * @var ?string $lastName Last name. Required if type = `individual`.
     */
    #[JsonProperty('lastName')]
    public ?string $lastName;

    /**
     * @var ?string $fullName Full legal name. Required if type = `entity`.
     */
    #[JsonProperty('fullName')]
    public ?string $fullName;

    /**
     * @var string $residenceCountry ISO 3166-1 alpha-3 country code (3 letters, e.g., `NLD`, `DEU`, `GBR`)
     */
    #[JsonProperty('residenceCountry')]
    public string $residenceCountry;

    /**
     * @var string $walletAddress Source wallet address
     */
    #[JsonProperty('walletAddress')]
    public string $walletAddress;

    /**
     * @var TravelRuleAddress $address
     */
    #[JsonProperty('address')]
    public TravelRuleAddress $address;

    /**
     * @param array{
     *   type: value-of<TravelRuleOriginatorType>,
     *   residenceCountry: string,
     *   walletAddress: string,
     *   address: TravelRuleAddress,
     *   firstName?: ?string,
     *   lastName?: ?string,
     *   fullName?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->type = $values['type'];
        $this->firstName = $values['firstName'] ?? null;
        $this->lastName = $values['lastName'] ?? null;
        $this->fullName = $values['fullName'] ?? null;
        $this->residenceCountry = $values['residenceCountry'];
        $this->walletAddress = $values['walletAddress'];
        $this->address = $values['address'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

<?php

namespace Whitebit\Withdraw\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Beneficiary postal address. Required for several VISAMASTER/SEPA configurations.
 */
class CreateWithdrawRequestBeneficiaryAddress extends JsonSerializableType
{
    /**
     * @var ?string $line1 Street address line 1.
     */
    #[JsonProperty('line1')]
    public ?string $line1;

    /**
     * @var ?string $line2 Street address line 2.
     */
    #[JsonProperty('line2')]
    public ?string $line2;

    /**
     * @var ?string $city City.
     */
    #[JsonProperty('city')]
    public ?string $city;

    /**
     * @var ?string $zip Postal / ZIP code.
     */
    #[JsonProperty('zip')]
    public ?string $zip;

    /**
     * @var ?string $country ISO country code.
     */
    #[JsonProperty('country')]
    public ?string $country;

    /**
     * @param array{
     *   line1?: ?string,
     *   line2?: ?string,
     *   city?: ?string,
     *   zip?: ?string,
     *   country?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->line1 = $values['line1'] ?? null;
        $this->line2 = $values['line2'] ?? null;
        $this->city = $values['city'] ?? null;
        $this->zip = $values['zip'] ?? null;
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

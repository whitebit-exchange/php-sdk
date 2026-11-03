<?php

namespace Whitebit\Deposit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetFiatDepositUrlRequestCustomerAddress extends JsonSerializableType
{
    /**
     * Customer address line1.
     *
     * ⚠️ Required if currency USD or EUR with VISAMASTER [provider](/glossary#provider).
     *
     * @var ?string $line1
     */
    #[JsonProperty('line1')]
    public ?string $line1;

    /**
     * @var ?string $line2 Customer address line2
     */
    #[JsonProperty('line2')]
    public ?string $line2;

    /**
     * Customer city.
     *
     * ⚠️ Required if currency USD or EUR with VISAMASTER [provider](/glossary#provider).
     *
     * @var ?string $city
     */
    #[JsonProperty('city')]
    public ?string $city;

    /**
     * Customer zip-code.
     *
     * ⚠️ Required if currency USD or EUR with VISAMASTER [provider](/glossary#provider).
     *
     * @var ?string $zipCode
     */
    #[JsonProperty('zipCode')]
    public ?string $zipCode;

    /**
     * Customer country code.
     *
     * ⚠️ Required if currency USD or EUR with VISAMASTER [provider](/glossary#provider).
     *
     * @var ?string $countryCode
     */
    #[JsonProperty('countryCode')]
    public ?string $countryCode;

    /**
     * @param array{
     *   line1?: ?string,
     *   line2?: ?string,
     *   city?: ?string,
     *   zipCode?: ?string,
     *   countryCode?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->line1 = $values['line1'] ?? null;
        $this->line2 = $values['line2'] ?? null;
        $this->city = $values['city'] ?? null;
        $this->zipCode = $values['zipCode'] ?? null;
        $this->countryCode = $values['countryCode'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

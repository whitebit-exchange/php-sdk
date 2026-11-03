<?php

namespace Whitebit\Deposit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use DateTime;
use Whitebit\Core\Types\Date;

/**
 * Customer information (required for USD/EUR with VISAMASTER [provider](/glossary#provider))
 */
class GetFiatDepositUrlRequestCustomer extends JsonSerializableType
{
    /**
     * Customer billing first name.
     *
     * ⚠️ Required if currency USD or EUR with VISAMASTER [provider](/glossary#provider).
     *
     * @var ?string $firstName
     */
    #[JsonProperty('firstName')]
    public ?string $firstName;

    /**
     * Customer billing last name.
     *
     * ⚠️ Required if currency USD or EUR with VISAMASTER [provider](/glossary#provider).
     *
     * @var ?string $lastName
     */
    #[JsonProperty('lastName')]
    public ?string $lastName;

    /**
     * Customer billing email.
     *
     * ⚠️ Required if currency USD or EUR with VISAMASTER [provider](/glossary#provider).
     *
     * @var ?string $email
     */
    #[JsonProperty('email')]
    public ?string $email;

    /**
     * Customer birth date (Format YYYY-MM-DD).
     *
     * ⚠️ Required if currency USD or EUR with VISAMASTER [provider](/glossary#provider).
     *
     * @var ?DateTime $birthDate
     */
    #[JsonProperty('birthDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $birthDate;

    /**
     * @var ?GetFiatDepositUrlRequestCustomerAddress $address
     */
    #[JsonProperty('address')]
    public ?GetFiatDepositUrlRequestCustomerAddress $address;

    /**
     * @param array{
     *   firstName?: ?string,
     *   lastName?: ?string,
     *   email?: ?string,
     *   birthDate?: ?DateTime,
     *   address?: ?GetFiatDepositUrlRequestCustomerAddress,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->firstName = $values['firstName'] ?? null;
        $this->lastName = $values['lastName'] ?? null;
        $this->email = $values['email'] ?? null;
        $this->birthDate = $values['birthDate'] ?? null;
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

<?php

namespace Whitebit\Withdraw\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Card details for card-acquiring rails. Use `cardToken` instead when available; raw card details apply only when a fresh card is being added.
 */
class CreateWithdrawRequestBeneficiaryCard extends JsonSerializableType
{
    /**
     * @var ?bool $save If `true`, persist the card for reuse on subsequent withdrawals.
     */
    #[JsonProperty('save')]
    public ?bool $save;

    /**
     * @var ?string $name Cardholder name as embossed on the card.
     */
    #[JsonProperty('name')]
    public ?string $name;

    /**
     * @var ?string $firstName Cardholder first name.
     */
    #[JsonProperty('firstName')]
    public ?string $firstName;

    /**
     * @var ?string $lastName Cardholder last name.
     */
    #[JsonProperty('lastName')]
    public ?string $lastName;

    /**
     * @var ?string $number Primary Account Number (PAN). Treat as PCI-scope sensitive data on the partner side.
     */
    #[JsonProperty('number')]
    public ?string $number;

    /**
     * @var ?string $month Card expiry month as a two-digit string (`01`-`12`).
     */
    #[JsonProperty('month')]
    public ?string $month;

    /**
     * @var ?string $year Card expiry year as a four-digit string.
     */
    #[JsonProperty('year')]
    public ?string $year;

    /**
     * @param array{
     *   save?: ?bool,
     *   name?: ?string,
     *   firstName?: ?string,
     *   lastName?: ?string,
     *   number?: ?string,
     *   month?: ?string,
     *   year?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->save = $values['save'] ?? null;
        $this->name = $values['name'] ?? null;
        $this->firstName = $values['firstName'] ?? null;
        $this->lastName = $values['lastName'] ?? null;
        $this->number = $values['number'] ?? null;
        $this->month = $values['month'] ?? null;
        $this->year = $values['year'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

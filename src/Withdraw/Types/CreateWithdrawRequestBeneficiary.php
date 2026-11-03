<?php

namespace Whitebit\Withdraw\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use DateTime;
use Whitebit\Core\Types\Date;

/**
 * Beneficiary information.
 *
 * ⚠️ Required if currency [ticker](/glossary#ticker) is one of: USD_VISAMASTER, EUR_VISAMASTER, USD, EUR.
 *
 * Per-field requirements vary by currency and provider. Card-related fields (`cardToken`, `card.*`, `cardTokenSave`, `fingerprintSession`) apply only to card-acquiring rails; bank-related fields (`bank.*`) apply to bank-rail withdrawals; `phone`, `email`, and `birthDate` are required for VISAMASTER/Mercuryo rails. See `/asset-status-list` for the active provider per currency.
 */
class CreateWithdrawRequestBeneficiary extends JsonSerializableType
{
    /**
     * Beneficiary first name. Max length: 40 symbols, latin letters and special characters.
     *
     * ⚠️ Required if currency [ticker](/glossary#ticker) is one of: USD_VISAMASTER, USD, EUR
     *
     * @var ?string $firstName
     */
    #[JsonProperty('firstName')]
    public ?string $firstName;

    /**
     * Beneficiary last name. Max length: 40 symbols, latin letters and special characters.
     *
     * ⚠️ Required if currency [ticker](/glossary#ticker) is one of: USD_VISAMASTER, USD, EUR
     *
     * @var ?string $lastName
     */
    #[JsonProperty('lastName')]
    public ?string $lastName;

    /**
     * Beneficiary phone number.
     *
     * ⚠️ Required if currency [ticker](/glossary#ticker) is one of: USD_VISAMASTER, EUR_VISAMASTER
     *
     * @var ?string $phone
     */
    #[JsonProperty('phone')]
    public ?string $phone;

    /**
     * Beneficiary email.
     *
     * ⚠️ Required if currency [ticker](/glossary#ticker) is one of: USD_VISAMASTER, EUR_VISAMASTER
     *
     * @var ?string $email
     */
    #[JsonProperty('email')]
    public ?string $email;

    /**
     * Beneficiary birth date. Format: YYYY-MM-DD.
     *
     * ⚠️ Required if currency [ticker](/glossary#ticker) is one of: USD_VISAMASTER, EUR_VISAMASTER, or when withdrawing through Mercuryo.
     *
     * @var ?DateTime $birthDate
     */
    #[JsonProperty('birthDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $birthDate;

    /**
     * @var ?string $code Beneficiary verification code returned by a prior verification step. Used by some card-acquiring flows that require a one-time verification challenge before settlement.
     */
    #[JsonProperty('code')]
    public ?string $code;

    /**
     * @var ?string $cardToken Tokenized payment-card identifier for card-acquiring rails. Use instead of raw PAN; obtain from the card-tokenisation endpoint or from a prior successful settlement on the same card.
     */
    #[JsonProperty('cardToken')]
    public ?string $cardToken;

    /**
     * @var ?bool $cardTokenSave If `true`, request the acquiring provider to persist the card token for reuse on subsequent withdrawals to the same beneficiary.
     */
    #[JsonProperty('cardTokenSave')]
    public ?bool $cardTokenSave;

    /**
     * @var ?string $fingerprintSession Anti-fraud device-fingerprint session identifier captured at the partner's checkout surface and forwarded to the acquiring provider. Required by some VISAMASTER configurations.
     */
    #[JsonProperty('fingerprintSession')]
    public ?string $fingerprintSession;

    /**
     * @var ?CreateWithdrawRequestBeneficiaryCard $card Card details for card-acquiring rails. Use `cardToken` instead when available; raw card details apply only when a fresh card is being added.
     */
    #[JsonProperty('card')]
    public ?CreateWithdrawRequestBeneficiaryCard $card;

    /**
     * @var ?CreateWithdrawRequestBeneficiaryAddress $address Beneficiary postal address. Required for several VISAMASTER/SEPA configurations.
     */
    #[JsonProperty('address')]
    public ?CreateWithdrawRequestBeneficiaryAddress $address;

    /**
     * @var ?CreateWithdrawRequestBeneficiaryBank $bank Beneficiary bank details for bank-rail withdrawals (used when the destination is an account number rather than an IBAN).
     */
    #[JsonProperty('bank')]
    public ?CreateWithdrawRequestBeneficiaryBank $bank;

    /**
     * @param array{
     *   firstName?: ?string,
     *   lastName?: ?string,
     *   phone?: ?string,
     *   email?: ?string,
     *   birthDate?: ?DateTime,
     *   code?: ?string,
     *   cardToken?: ?string,
     *   cardTokenSave?: ?bool,
     *   fingerprintSession?: ?string,
     *   card?: ?CreateWithdrawRequestBeneficiaryCard,
     *   address?: ?CreateWithdrawRequestBeneficiaryAddress,
     *   bank?: ?CreateWithdrawRequestBeneficiaryBank,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->firstName = $values['firstName'] ?? null;
        $this->lastName = $values['lastName'] ?? null;
        $this->phone = $values['phone'] ?? null;
        $this->email = $values['email'] ?? null;
        $this->birthDate = $values['birthDate'] ?? null;
        $this->code = $values['code'] ?? null;
        $this->cardToken = $values['cardToken'] ?? null;
        $this->cardTokenSave = $values['cardTokenSave'] ?? null;
        $this->fingerprintSession = $values['fingerprintSession'] ?? null;
        $this->card = $values['card'] ?? null;
        $this->address = $values['address'] ?? null;
        $this->bank = $values['bank'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

<?php

namespace Whitebit\Withdraw\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Withdraw\Types\CreateWithdrawRequestBeneficiary;
use Whitebit\Withdraw\Types\CreateWithdrawRequestTravelRule;

class CreateWithdrawRequest extends JsonSerializableType
{
    /**
     * Currency's [ticker](/glossary#ticker). Example: BTC
     *
     * ⚠️ Currencies ticker must have "can_deposit" status equal to "true". Use [Asset Status endpoint](/public/http-v4/asset-status-list) to know more about currency.
     *
     * @var string $ticker
     */
    #[JsonProperty('ticker')]
    public string $ticker;

    /**
     * @var string $amount Withdraw amount (including [fee](/glossary#fee)). To add the fee to the specified amount, use the /main-account/withdraw-pay request.
     */
    #[JsonProperty('amount')]
    public string $amount;

    /**
     * @var string $address Target address (wallet address for cryptocurrencies, identifier/[card token](/glossary#card-token) for [fiat](/glossary#fiat) currencies)
     */
    #[JsonProperty('address')]
    public string $address;

    /**
     * [Memo](/glossary#memodestination-tag).
     *
     * ⚠️ Required if currency is memoable.
     *
     * @var ?string $memo
     */
    #[JsonProperty('memo')]
    public ?string $memo;

    /**
     * Unique transaction identifier. Any string up to 255 characters; not validated as a UUID.
     *
     * ⚠️ Generate a new unique ID for each withdrawal request.
     *
     * @var string $uniqueId
     */
    #[JsonProperty('uniqueId')]
    public string $uniqueId;

    /**
     * [Fiat](/glossary#fiat) currency [provider](/glossary#provider). Example: VISAMASTER
     *
     * ⚠️ Required for fiat currencies. Currency provider should be taken from [Asset Status endpoint](/public/http-v4/asset-status-list) response.
     *
     * @var ?string $provider
     */
    #[JsonProperty('provider')]
    public ?string $provider;

    /**
     * Cryptocurrency network. Available for multi network currencies. Example: OMNI
     *
     * ⚠️ Currency network should be taken from [Asset Status endpoint](/public/http-v4/asset-status-list) response. Default for USDT is ERC20
     *
     * @var ?string $network
     */
    #[JsonProperty('network')]
    public ?string $network;

    /**
     * @var ?bool $partialEnable Optional parameter for [FIAT](/glossary#fiat) withdrawals with increased Maximum Limit if set as "true". To use this parameter, the application must support "Partially successful" withdrawal status and latest updates in deposit/withdrawal history.
     */
    #[JsonProperty('partialEnable')]
    public ?bool $partialEnable;

    /**
     * End-customer IP address forwarded to the [fiat](/glossary#fiat) [provider](/glossary#provider) for antifraud checks before the withdrawal is processed.
     *
     * ⚠️ Required if currency [ticker](/glossary#ticker) is USD or EUR with VISAMASTER [provider](/glossary#provider).
     *
     * @var ?string $customerIp
     */
    #[JsonProperty('customerIp')]
    public ?string $customerIp;

    /**
     * Beneficiary information.
     *
     * ⚠️ Required if currency [ticker](/glossary#ticker) is one of: USD_VISAMASTER, EUR_VISAMASTER, USD, EUR.
     *
     * Per-field requirements vary by currency and provider. Card-related fields (`cardToken`, `card.*`, `cardTokenSave`, `fingerprintSession`) apply only to card-acquiring rails; bank-related fields (`bank.*`) apply to bank-rail withdrawals; `phone`, `email`, and `birthDate` are required for VISAMASTER/Mercuryo rails. See `/asset-status-list` for the active provider per currency.
     *
     * @var ?CreateWithdrawRequestBeneficiary $beneficiary
     */
    #[JsonProperty('beneficiary')]
    public ?CreateWithdrawRequestBeneficiary $beneficiary;

    /**
     * Travel Rule information for regulatory compliance.
     *
     * ⚠️ Required if currency is crypto and the account is from [EEA](/glossary#european-economic-area-eea)
     *
     * See [Travel Rule Overview](/api-reference/travel-rule/overview) for complete documentation.
     *
     * **Legacy format:** The API still accepts the old flat format (`type`, `vasp`, `name`, `address` fields), but this format will not pass Travel Rule verification. To complete Travel Rule compliance, use the new structured format with `walletType`, `beneficiary`, and `vasp` objects.
     *
     * @var ?CreateWithdrawRequestTravelRule $travelRule
     */
    #[JsonProperty('travelRule')]
    public ?CreateWithdrawRequestTravelRule $travelRule;

    /**
     * Description of withdrawal destination
     *
     * ⚠️ Required if currency is crypto and withdrawal from whitebit-tr.com
     *
     * @var ?string $paymentDescription
     */
    #[JsonProperty('paymentDescription')]
    public ?string $paymentDescription;

    /**
     * @var string $request Request signature
     */
    #[JsonProperty('request')]
    public string $request;

    /**
     * @var int $nonce Unique request identifier
     */
    #[JsonProperty('nonce')]
    public int $nonce;

    /**
     * @param array{
     *   ticker: string,
     *   amount: string,
     *   address: string,
     *   uniqueId: string,
     *   request: string,
     *   nonce: int,
     *   memo?: ?string,
     *   provider?: ?string,
     *   network?: ?string,
     *   partialEnable?: ?bool,
     *   customerIp?: ?string,
     *   beneficiary?: ?CreateWithdrawRequestBeneficiary,
     *   travelRule?: ?CreateWithdrawRequestTravelRule,
     *   paymentDescription?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->ticker = $values['ticker'];
        $this->amount = $values['amount'];
        $this->address = $values['address'];
        $this->memo = $values['memo'] ?? null;
        $this->uniqueId = $values['uniqueId'];
        $this->provider = $values['provider'] ?? null;
        $this->network = $values['network'] ?? null;
        $this->partialEnable = $values['partialEnable'] ?? null;
        $this->customerIp = $values['customerIp'] ?? null;
        $this->beneficiary = $values['beneficiary'] ?? null;
        $this->travelRule = $values['travelRule'] ?? null;
        $this->paymentDescription = $values['paymentDescription'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

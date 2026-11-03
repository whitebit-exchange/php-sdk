<?php

namespace Whitebit\Withdraw\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class WithdrawRequest extends JsonSerializableType
{
    /**
     * @var string $ticker Currencies [ticker](/glossary#ticker). Example: BTC ⚠️ Currencies ticker must have "can_deposit" status equal to "true". Use [Asset Status endpoint](/public/http-v4/asset-status-list) to know more about currency.
     */
    #[JsonProperty('ticker')]
    public string $ticker;

    /**
     * @var string $amount Withdraw amount (including [fee](/glossary#fee)). To add the fee to the specified amount, use the /main-account/withdraw-pay request
     */
    #[JsonProperty('amount')]
    public string $amount;

    /**
     * @var string $address Target address (wallet address for cryptocurrencies, identifier/[card token](/glossary#card-token) for [fiat](/glossary#fiat) currencies)
     */
    #[JsonProperty('address')]
    public string $address;

    /**
     * @var ?string $memo Required if currency is memoable. See [memo](/glossary#memodestination-tag) for details.
     */
    #[JsonProperty('memo')]
    public ?string $memo;

    /**
     * @var string $uniqueId Unique transaction identifier. Any string up to 255 characters; not validated as a UUID. ⚠️ Generate a new unique ID for each withdrawal request.
     */
    #[JsonProperty('uniqueId')]
    public string $uniqueId;

    /**
     * @var ?string $provider [Fiat](/glossary#fiat) currency [provider](/glossary#provider). Example: VISAMASTER ⚠️ Currency provider should be taken from [Asset Status endpoint](/public/http-v4/asset-status-list) response. Required if currency is fiat.
     */
    #[JsonProperty('provider')]
    public ?string $provider;

    /**
     * @var ?string $network Cryptocurrency network. Available for [multinetwork](/glossary#multinetwork) currencies. Example: OMNI ⚠️ Currency network should be taken from [Asset Status endpoint](/public/http-v4/asset-status-list) response. Default for USDT is ERC20
     */
    #[JsonProperty('network')]
    public ?string $network;

    /**
     * @var ?bool $partialEnable Optional parameter for [FIAT](/glossary#fiat) withdrawals with increased Maximum Limit if set as "true". To use this parameter, the application must support "Partially successful" withdrawal status and latest updates in deposit/withdrawal history.
     */
    #[JsonProperty('partialEnable')]
    public ?bool $partialEnable;

    /**
     * @var ?string $customerIp End-customer IP address forwarded to the [fiat](/glossary#fiat) [provider](/glossary#provider) for antifraud checks before the withdrawal is processed. ⚠️ Required if currency [ticker](/glossary#ticker) is USD or EUR with VISAMASTER [provider](/glossary#provider).
     */
    #[JsonProperty('customerIp')]
    public ?string $customerIp;

    /**
     * @var ?array<string, mixed> $beneficiary Beneficiary information data. Required if currency [ticker](/glossary#ticker) is one of: USD_VISAMASTER, EUR_VISAMASTER, USD, EUR
     */
    #[JsonProperty('beneficiary'), ArrayType(['string' => 'mixed'])]
    public ?array $beneficiary;

    /**
     * @var ?array<string, mixed> $travelRule Travel Rule information data. Required if currency is crypto and the account is from [EEA](/glossary#european-economic-area-eea)
     */
    #[JsonProperty('travelRule'), ArrayType(['string' => 'mixed'])]
    public ?array $travelRule;

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
     *   beneficiary?: ?array<string, mixed>,
     *   travelRule?: ?array<string, mixed>,
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
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

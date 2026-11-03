<?php

namespace Whitebit\Deposit\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Deposit\Types\GetFiatDepositUrlRequestCustomer;

class GetFiatDepositUrlRequest extends JsonSerializableType
{
    /**
     * @var string $ticker Currency's [ticker](/glossary#ticker) ([fiat](/glossary#fiat)). ⚠️ Currencies ticker should be fiat and has "can_deposit" status must be "true". Use [Asset Status endpoint](/public/http-v4/asset-status-list) to know more about currency.
     */
    #[JsonProperty('ticker')]
    public string $ticker;

    /**
     * @var string $provider [Fiat](/glossary#fiat) currency [provider](/glossary#provider). ⚠️ Currency provider should be taken from [Asset Status endpoint](/public/http-v4/asset-status-list) response.
     */
    #[JsonProperty('provider')]
    public string $provider;

    /**
     * @var string $amount Deposit amount
     */
    #[JsonProperty('amount')]
    public string $amount;

    /**
     * @var string $uniqueId Unique transaction identifier on client's side. Any string up to 255 characters; not validated as a UUID.
     */
    #[JsonProperty('uniqueId')]
    public string $uniqueId;

    /**
     * @var ?GetFiatDepositUrlRequestCustomer $customer Customer information (required for USD/EUR with VISAMASTER [provider](/glossary#provider))
     */
    #[JsonProperty('customer')]
    public ?GetFiatDepositUrlRequestCustomer $customer;

    /**
     * @var ?string $successLink Customer will be redirected to this URL by acquiring [provider](/glossary#provider) after success deposit. To activate this feature, please contact support
     */
    #[JsonProperty('successLink')]
    public ?string $successLink;

    /**
     * @var ?string $failureLink Customer will be redirected to this URL in case of fail or rejection on acquiring provider side. To activate this feature, please contact support
     */
    #[JsonProperty('failureLink')]
    public ?string $failureLink;

    /**
     * @var ?string $returnLink Customer will be redirected to the URL defined if selects 'back' option after from the payment success or failure page. To activate this feature, define desired link. If not populated, option 'back' won't be displayed
     */
    #[JsonProperty('returnLink')]
    public ?string $returnLink;

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
     *   provider: string,
     *   amount: string,
     *   uniqueId: string,
     *   request: string,
     *   nonce: int,
     *   customer?: ?GetFiatDepositUrlRequestCustomer,
     *   successLink?: ?string,
     *   failureLink?: ?string,
     *   returnLink?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->ticker = $values['ticker'];
        $this->provider = $values['provider'];
        $this->amount = $values['amount'];
        $this->uniqueId = $values['uniqueId'];
        $this->customer = $values['customer'] ?? null;
        $this->successLink = $values['successLink'] ?? null;
        $this->failureLink = $values['failureLink'] ?? null;
        $this->returnLink = $values['returnLink'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

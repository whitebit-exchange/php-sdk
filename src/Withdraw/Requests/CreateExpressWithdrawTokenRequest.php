<?php

namespace Whitebit\Withdraw\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CreateExpressWithdrawTokenRequest extends JsonSerializableType
{
    /**
     * Currency [ticker](/glossary#ticker) to charge. Example: USDT
     *
     * ⚠️ The ticker must be a withdrawal-enabled cryptocurrency; the endpoint rejects [fiat](/glossary#fiat) tickers. Use [Asset Status endpoint](/public/http-v4/asset-status-list) to check the withdrawal status of a currency.
     *
     * @var string $ticker
     */
    #[JsonProperty('ticker')]
    public string $ticker;

    /**
     * Amount to charge in the specified [ticker](/glossary#ticker). Numeric string.
     *
     * ⚠️ The amount converted to USDT-equivalent must not exceed 10,000; the endpoint rejects larger amounts with error code `191`.
     *
     * @var string $amount
     */
    #[JsonProperty('amount')]
    public string $amount;

    /**
     * @var string $externalId Partner-side reference for the payment (order or invoice identifier), unique per partner account. The identifier powers idempotency and replay protection: a pending `externalId` with an identical `ticker` and `amount` returns the same token; the endpoint rejects an already-paid `externalId` with error code `19`.
     */
    #[JsonProperty('externalId')]
    public string $externalId;

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
     *   externalId: string,
     *   request: string,
     *   nonce: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->ticker = $values['ticker'];
        $this->amount = $values['amount'];
        $this->externalId = $values['externalId'];
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

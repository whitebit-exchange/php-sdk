<?php

namespace Whitebit\CryptoLendingFlex\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class WithdrawFromFlexInvestmentRequest extends JsonSerializableType
{
    /**
     * @var string $plan Plan external ID (UUID).
     */
    #[JsonProperty('plan')]
    public string $plan;

    /**
     * @var string $amount Withdrawal amount.
     */
    #[JsonProperty('amount')]
    public string $amount;

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
     *   plan: string,
     *   amount: string,
     *   request: string,
     *   nonce: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->plan = $values['plan'];
        $this->amount = $values['amount'];
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

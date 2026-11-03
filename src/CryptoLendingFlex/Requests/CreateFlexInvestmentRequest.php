<?php

namespace Whitebit\CryptoLendingFlex\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CreateFlexInvestmentRequest extends JsonSerializableType
{
    /**
     * @var string $plan Plan external ID (UUID).
     */
    #[JsonProperty('plan')]
    public string $plan;

    /**
     * @var string $amount Investment amount.
     */
    #[JsonProperty('amount')]
    public string $amount;

    /**
     * @var ?bool $withReinvest Enable auto-reinvestment.
     */
    #[JsonProperty('withReinvest')]
    public ?bool $withReinvest;

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
     *   withReinvest?: ?bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->plan = $values['plan'];
        $this->amount = $values['amount'];
        $this->withReinvest = $values['withReinvest'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

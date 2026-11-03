<?php

namespace Whitebit\CryptoLendingFlex\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CloseFlexInvestmentRequest extends JsonSerializableType
{
    /**
     * @var string $plan Plan external ID (UUID).
     */
    #[JsonProperty('plan')]
    public string $plan;

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
     *   request: string,
     *   nonce: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->plan = $values['plan'];
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

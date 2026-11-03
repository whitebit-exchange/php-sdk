<?php

namespace Whitebit\CollateralTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class ChangeCollateralAccountLeverageRequest extends JsonSerializableType
{
    /**
     * @var int $leverage Target leverage level. Accepted values: `1`, `2`, `3`, `5`, `10`, `20`, `50`, `100`. The effective maximum depends on the market's `max_leverage`.
     */
    #[JsonProperty('leverage')]
    public int $leverage;

    /**
     * @var string $request
     */
    #[JsonProperty('request')]
    public string $request;

    /**
     * @var int $nonce
     */
    #[JsonProperty('nonce')]
    public int $nonce;

    /**
     * @param array{
     *   leverage: int,
     *   request: string,
     *   nonce: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->leverage = $values['leverage'];
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

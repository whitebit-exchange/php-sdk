<?php

namespace Whitebit\CollateralTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CancelConditionalOrderRequest extends JsonSerializableType
{
    /**
     * @var string $market Market of the conditional order to cancel. Example: BTC_USDT
     */
    #[JsonProperty('market')]
    public string $market;

    /**
     * @var int $id Conditional order identifier. Obtain from the [query unexecuted conditional orders](/api-reference/collateral-trading/query-unexecuted-conditional-orders) endpoint.
     */
    #[JsonProperty('id')]
    public int $id;

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
     *   market: string,
     *   id: int,
     *   request: string,
     *   nonce: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->market = $values['market'];
        $this->id = $values['id'];
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

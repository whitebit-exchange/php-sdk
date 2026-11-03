<?php

namespace Whitebit\CollateralTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CancelOtoOrderRequest extends JsonSerializableType
{
    /**
     * @var string $market
     */
    #[JsonProperty('market')]
    public string $market;

    /**
     * @var int $otoId
     */
    #[JsonProperty('otoId')]
    public int $otoId;

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
     *   otoId: int,
     *   request: string,
     *   nonce: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->market = $values['market'];
        $this->otoId = $values['otoId'];
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

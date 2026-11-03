<?php

namespace Whitebit\CollateralTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class UpdateHedgeModeRequest extends JsonSerializableType
{
    /**
     * @var bool $hedgeMode Set to `true` to enable hedge mode (simultaneous long and short positions) or `false` to use one-way mode.
     */
    #[JsonProperty('hedgeMode')]
    public bool $hedgeMode;

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
     *   hedgeMode: bool,
     *   request: string,
     *   nonce: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->hedgeMode = $values['hedgeMode'];
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

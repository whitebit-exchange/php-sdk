<?php

namespace Whitebit\CollateralTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetOpenPositionsRequest extends JsonSerializableType
{
    /**
     * Filter by specific market. For example: BTC_USDT
     *
     * If not specified, returns all open positions.
     *
     * @var ?string $market
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?string $request Request signature
     */
    #[JsonProperty('request')]
    public ?string $request;

    /**
     * @var ?int $nonce Unique request identifier
     */
    #[JsonProperty('nonce')]
    public ?int $nonce;

    /**
     * @param array{
     *   market?: ?string,
     *   request?: ?string,
     *   nonce?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->market = $values['market'] ?? null;
        $this->request = $values['request'] ?? null;
        $this->nonce = $values['nonce'] ?? null;
    }
}

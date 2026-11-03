<?php

namespace Whitebit\SpotTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetKillSwitchStatusRequest extends JsonSerializableType
{
    /**
     * @var ?string $market Available [market](/glossary#market). Example: BTC_USDT
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?string $request
     */
    #[JsonProperty('request')]
    public ?string $request;

    /**
     * @var ?int $nonce
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

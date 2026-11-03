<?php

namespace Whitebit\SpotTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class TradeAccountBalanceRequest extends JsonSerializableType
{
    /**
     * @var ?string $ticker Currency's [ticker](/glossary#ticker). Example: BTC
     */
    #[JsonProperty('ticker')]
    public ?string $ticker;

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
     *   ticker?: ?string,
     *   request?: ?string,
     *   nonce?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->ticker = $values['ticker'] ?? null;
        $this->request = $values['request'] ?? null;
        $this->nonce = $values['nonce'] ?? null;
    }
}

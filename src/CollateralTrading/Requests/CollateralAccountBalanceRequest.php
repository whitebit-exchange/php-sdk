<?php

namespace Whitebit\CollateralTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CollateralAccountBalanceRequest extends JsonSerializableType
{
    /**
     * [Asset](/glossary#assets) to be filtered. For example: BTC
     *
     * If not specified, returns balances for all assets.
     *
     * @var ?string $ticker
     */
    #[JsonProperty('ticker')]
    public ?string $ticker;

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

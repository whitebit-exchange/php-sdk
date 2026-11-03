<?php

namespace Whitebit\CryptoLendingFixed\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetFixedPlansRequest extends JsonSerializableType
{
    /**
     * @var ?string $ticker [Invest plan](/glossary#crypto-lending) source currency's [ticker](/glossary#ticker). Example: BTC
     */
    #[JsonProperty('ticker')]
    public ?string $ticker;

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
     *   request: string,
     *   nonce: int,
     *   ticker?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->ticker = $values['ticker'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

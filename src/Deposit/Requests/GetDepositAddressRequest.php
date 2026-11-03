<?php

namespace Whitebit\Deposit\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetDepositAddressRequest extends JsonSerializableType
{
    /**
     * @var string $ticker Currencies ticker. Example: BTC ⚠️ Currency [ticker](/glossary#ticker) should not be [fiat](/glossary#fiat) and it’s “can_deposit” status must be “true”. See [Asset Status endpoint](/public/http-v4/asset-status-list) response for the status.
     */
    #[JsonProperty('ticker')]
    public string $ticker;

    /**
     * @var ?string $network Cryptocurrency network. ⚠️ If currency has multiple networks like USDT, specify the network to use. See [ticker](/glossary#ticker) networks list in “networks” field from response [Asset Status endpoint](/public/http-v4/asset-status-list).
     */
    #[JsonProperty('network')]
    public ?string $network;

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
     *   ticker: string,
     *   request: string,
     *   nonce: int,
     *   network?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->ticker = $values['ticker'];
        $this->network = $values['network'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

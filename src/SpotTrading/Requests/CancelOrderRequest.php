<?php

namespace Whitebit\SpotTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CancelOrderRequest extends JsonSerializableType
{
    /**
     * @var string $market Available [market](/glossary#market). Example: BTC_USDT
     */
    #[JsonProperty('market')]
    public string $market;

    /**
     * @var ?int $orderId Order Id. Example: 4180284841. Required if clientOrderId is not set.
     */
    #[JsonProperty('orderId')]
    public ?int $orderId;

    /**
     * @var ?string $clientOrderId Custom client order id. Example: 'customId11'. Required if orderId is not set.
     */
    #[JsonProperty('clientOrderId')]
    public ?string $clientOrderId;

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
     *   request: string,
     *   nonce: int,
     *   orderId?: ?int,
     *   clientOrderId?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->market = $values['market'];
        $this->orderId = $values['orderId'] ?? null;
        $this->clientOrderId = $values['clientOrderId'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

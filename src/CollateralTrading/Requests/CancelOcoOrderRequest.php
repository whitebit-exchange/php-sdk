<?php

namespace Whitebit\CollateralTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CancelOcoOrderRequest extends JsonSerializableType
{
    /**
     * @var string $market Market of the OCO order to cancel. Example: BTC_USDT
     */
    #[JsonProperty('market')]
    public string $market;

    /**
     * @var ?int $orderId OCO order identifier (the `id` returned at creation and by the OCO listings). Required if `clientOrderId` is not set; mutually exclusive with `clientOrderId`.
     */
    #[JsonProperty('orderId')]
    public ?int $orderId;

    /**
     * @var ?string $clientOrderId Client-defined order ID supplied at order creation. Required if `orderId` is not set; mutually exclusive with `orderId`.
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

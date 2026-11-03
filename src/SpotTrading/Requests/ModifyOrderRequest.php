<?php

namespace Whitebit\SpotTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\SpotTrading\Types\ModifyOrderRequestStp;

class ModifyOrderRequest extends JsonSerializableType
{
    /**
     * @var ?int $orderId Active order id. Required if clientOrderId is not set.
     */
    #[JsonProperty('orderId')]
    public ?int $orderId;

    /**
     * @var ?string $clientOrderId Identifier should be unique and contain letters, dashes, numbers, dots or underscores. Required if orderId is not set.
     */
    #[JsonProperty('clientOrderId')]
    public ?string $clientOrderId;

    /**
     * @var string $market Available [market](/glossary#market). Example: BTC_USDT
     */
    #[JsonProperty('market')]
    public string $market;

    /**
     * @var ?string $amount Amount of [stock](/glossary#stock) currency to buy or sell. Example: '0.001' or 0.001
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?string $total Total of [money](/glossary#money) currency to buy or sell. Example: '0.001' or 0.001
     */
    #[JsonProperty('total')]
    public ?string $total;

    /**
     * @var ?string $price Price in [money](/glossary#money) currency. Example: '9800' or 9800
     */
    #[JsonProperty('price')]
    public ?string $price;

    /**
     * @var ?string $activationPrice Activation price in [money](/glossary#money) currency. Example: '10000' or 10000
     */
    #[JsonProperty('activationPrice')]
    public ?string $activationPrice;

    /**
     * Self-trade prevention mode. Allowed values: `no` (self-trades allowed), `cb` (cancel both the new and the existing order), `cn` (cancel the new order, keep the existing), `co` (cancel the existing order, place the new one). Default: `no`.
     *
     * Legacy values `cancel_both`, `cancel_new`, `cancel_old` are deprecated: the API accepts the legacy values with identical behavior until a deprecation deadline is announced, then rejects the legacy values. Responses always return the abbreviated form, regardless of which variant the request used.
     *
     * See [Self-Trade Prevention](/platform/self-trade-prevention).
     *
     * @var ?value-of<ModifyOrderRequestStp> $stp
     */
    #[JsonProperty('stp')]
    public ?string $stp;

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
     *   amount?: ?string,
     *   total?: ?string,
     *   price?: ?string,
     *   activationPrice?: ?string,
     *   stp?: ?value-of<ModifyOrderRequestStp>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->orderId = $values['orderId'] ?? null;
        $this->clientOrderId = $values['clientOrderId'] ?? null;
        $this->market = $values['market'];
        $this->amount = $values['amount'] ?? null;
        $this->total = $values['total'] ?? null;
        $this->price = $values['price'] ?? null;
        $this->activationPrice = $values['activationPrice'] ?? null;
        $this->stp = $values['stp'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

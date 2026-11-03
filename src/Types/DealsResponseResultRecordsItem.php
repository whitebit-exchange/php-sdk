<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class DealsResponseResultRecordsItem extends JsonSerializableType
{
    /**
     * @var ?float $time Deal time in Unix time
     */
    #[JsonProperty('time')]
    public ?float $time;

    /**
     * @var ?int $id Deal ID
     */
    #[JsonProperty('id')]
    public ?int $id;

    /**
     * @var ?int $side Side: 1=sell, 2=buy/bid
     */
    #[JsonProperty('side')]
    public ?int $side;

    /**
     * @var ?int $role Role: 1=[maker](/glossary#maker), 2=taker
     */
    #[JsonProperty('role')]
    public ?int $role;

    /**
     * @var ?string $price Deal price
     */
    #[JsonProperty('price')]
    public ?string $price;

    /**
     * @var ?string $amount [Stock](/glossary#stock) amount
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?string $deal [Money](/glossary#money) amount
     */
    #[JsonProperty('deal')]
    public ?string $deal;

    /**
     * @var ?string $fee Deal fee expressed in asset in fee_asset
     */
    #[JsonProperty('fee')]
    public ?string $fee;

    /**
     * @var ?int $orderId Order ID
     */
    #[JsonProperty('order_id')]
    public ?int $orderId;

    /**
     * @var ?int $dealOrderId Counterparty Order ID
     */
    #[JsonProperty('deal_order_id')]
    public ?int $dealOrderId;

    /**
     * @var ?string $market [Market](/glossary#market)
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?string $clientOrderId Client Order ID
     */
    #[JsonProperty('client_order_id')]
    public ?string $clientOrderId;

    /**
     * @var ?string $feeAsset Fee asset type
     */
    #[JsonProperty('fee_asset')]
    public ?string $feeAsset;

    /**
     * @param array{
     *   time?: ?float,
     *   id?: ?int,
     *   side?: ?int,
     *   role?: ?int,
     *   price?: ?string,
     *   amount?: ?string,
     *   deal?: ?string,
     *   fee?: ?string,
     *   orderId?: ?int,
     *   dealOrderId?: ?int,
     *   market?: ?string,
     *   clientOrderId?: ?string,
     *   feeAsset?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->time = $values['time'] ?? null;
        $this->id = $values['id'] ?? null;
        $this->side = $values['side'] ?? null;
        $this->role = $values['role'] ?? null;
        $this->price = $values['price'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->deal = $values['deal'] ?? null;
        $this->fee = $values['fee'] ?? null;
        $this->orderId = $values['orderId'] ?? null;
        $this->dealOrderId = $values['dealOrderId'] ?? null;
        $this->market = $values['market'] ?? null;
        $this->clientOrderId = $values['clientOrderId'] ?? null;
        $this->feeAsset = $values['feeAsset'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

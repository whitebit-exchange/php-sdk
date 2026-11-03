<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Types\ActiveOrderStatus;

/**
 * Stop loss order details
 */
class CreateCollateralOcoOrderResponseStopLoss extends JsonSerializableType
{
    /**
     * @var ?int $orderId Order identifier
     */
    #[JsonProperty('orderId')]
    public ?int $orderId;

    /**
     * @var ?string $clientOrderId Custom order identifier. Empty string if not specified
     */
    #[JsonProperty('clientOrderId')]
    public ?string $clientOrderId;

    /**
     * @var ?string $market Market name
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?value-of<CreateCollateralOcoOrderResponseStopLossSide> $side Order side
     */
    #[JsonProperty('side')]
    public ?string $side;

    /**
     * @var ?string $type Order type
     */
    #[JsonProperty('type')]
    public ?string $type;

    /**
     * @var ?float $timestamp Unix timestamp in seconds (UTC) of order creation, with microsecond precision.
     */
    #[JsonProperty('timestamp')]
    public ?float $timestamp;

    /**
     * @var ?string $dealMoney Executed amount in money
     */
    #[JsonProperty('dealMoney')]
    public ?string $dealMoney;

    /**
     * @var ?string $dealStock Executed amount in stock
     */
    #[JsonProperty('dealStock')]
    public ?string $dealStock;

    /**
     * @var ?string $amount Order amount
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?string $takerFee Taker fee ratio
     */
    #[JsonProperty('takerFee')]
    public ?string $takerFee;

    /**
     * @var ?string $makerFee Maker fee ratio
     */
    #[JsonProperty('makerFee')]
    public ?string $makerFee;

    /**
     * @var ?string $left Unexecuted amount in stock
     */
    #[JsonProperty('left')]
    public ?string $left;

    /**
     * @var ?string $dealFee Executed fee by deal
     */
    #[JsonProperty('dealFee')]
    public ?string $dealFee;

    /**
     * @var ?bool $postOnly Post-only flag
     */
    #[JsonProperty('post_only')]
    public ?bool $postOnly;

    /**
     * @var ?float $mtime Timestamp of order modification
     */
    #[JsonProperty('mtime')]
    public ?float $mtime;

    /**
     * @var ?string $price Order price
     */
    #[JsonProperty('price')]
    public ?string $price;

    /**
     * @var ?string $activationPrice Activation price
     */
    #[JsonProperty('activation_price')]
    public ?string $activationPrice;

    /**
     * @var ?value-of<CreateCollateralOcoOrderResponseStopLossActivationCondition> $activationCondition Trigger condition derived from `side` (response-only, cannot be overridden): `buy` → `gte`, `sell` → `lte`.
     */
    #[JsonProperty('activation_condition')]
    public ?string $activationCondition;

    /**
     * @var ?int $activated Activation status (0 - not activated, 1 - activated)
     */
    #[JsonProperty('activated')]
    public ?int $activated;

    /**
     * @var ?value-of<ActiveOrderStatus> $status
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var ?string $stp Self-trade prevention mode. Possible values: `no`, `cb`, `cn`, `co`. Always returned in abbreviated form, even when the request used a legacy value.
     */
    #[JsonProperty('stp')]
    public ?string $stp;

    /**
     * @var ?value-of<CreateCollateralOcoOrderResponseStopLossPositionSide> $positionSide Position side
     */
    #[JsonProperty('positionSide')]
    public ?string $positionSide;

    /**
     * @param array{
     *   orderId?: ?int,
     *   clientOrderId?: ?string,
     *   market?: ?string,
     *   side?: ?value-of<CreateCollateralOcoOrderResponseStopLossSide>,
     *   type?: ?string,
     *   timestamp?: ?float,
     *   dealMoney?: ?string,
     *   dealStock?: ?string,
     *   amount?: ?string,
     *   takerFee?: ?string,
     *   makerFee?: ?string,
     *   left?: ?string,
     *   dealFee?: ?string,
     *   postOnly?: ?bool,
     *   mtime?: ?float,
     *   price?: ?string,
     *   activationPrice?: ?string,
     *   activationCondition?: ?value-of<CreateCollateralOcoOrderResponseStopLossActivationCondition>,
     *   activated?: ?int,
     *   status?: ?value-of<ActiveOrderStatus>,
     *   stp?: ?string,
     *   positionSide?: ?value-of<CreateCollateralOcoOrderResponseStopLossPositionSide>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->orderId = $values['orderId'] ?? null;
        $this->clientOrderId = $values['clientOrderId'] ?? null;
        $this->market = $values['market'] ?? null;
        $this->side = $values['side'] ?? null;
        $this->type = $values['type'] ?? null;
        $this->timestamp = $values['timestamp'] ?? null;
        $this->dealMoney = $values['dealMoney'] ?? null;
        $this->dealStock = $values['dealStock'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->takerFee = $values['takerFee'] ?? null;
        $this->makerFee = $values['makerFee'] ?? null;
        $this->left = $values['left'] ?? null;
        $this->dealFee = $values['dealFee'] ?? null;
        $this->postOnly = $values['postOnly'] ?? null;
        $this->mtime = $values['mtime'] ?? null;
        $this->price = $values['price'] ?? null;
        $this->activationPrice = $values['activationPrice'] ?? null;
        $this->activationCondition = $values['activationCondition'] ?? null;
        $this->activated = $values['activated'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->stp = $values['stp'] ?? null;
        $this->positionSide = $values['positionSide'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

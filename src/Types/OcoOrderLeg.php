<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * OCO order leg as returned by `/api/v4/oco-orders` and `/api/v4/order/oco-cancel`. Field names use snake_case (`post_only`, `activation_price`) — unlike the camelCase legs returned by `/api/v4/conditional-orders`.
 */
class OcoOrderLeg extends JsonSerializableType
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
     * @var ?value-of<OcoOrderLegSide> $side Order side
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
     * @var ?string $feeAsset Currency ticker of the asset used to pay the trading fee. Omitted when empty.
     */
    #[JsonProperty('feeAsset')]
    public ?string $feeAsset;

    /**
     * @var ?string $status Order status (for example `OPEN` for an active leg, `CANCELED` after cancellation).
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var ?string $stp Self-trade prevention mode. Possible values: `no`, `cb`, `cn`, `co`. Always returned in abbreviated form, even when the request used a legacy value.
     */
    #[JsonProperty('stp')]
    public ?string $stp;

    /**
     * @var ?value-of<OcoOrderLegPositionSide> $positionSide Position side of the leg. Present on futures markets (`BOTH` in one-way mode, `LONG`/`SHORT` in hedge mode); omitted on margin-spot markets.
     */
    #[JsonProperty('positionSide')]
    public ?string $positionSide;

    /**
     * @var ?bool $reduceOnly Reduce-only flag. When `true`, the leg can only reduce or close an existing position.
     */
    #[JsonProperty('reduceOnly')]
    public ?bool $reduceOnly;

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
     * @var ?string $activationPrice Activation price. Returned on the stop-loss leg
     */
    #[JsonProperty('activation_price')]
    public ?string $activationPrice;

    /**
     * @var ?value-of<OcoOrderLegActivationCondition> $activationCondition Trigger condition derived from `side` (response-only, cannot be overridden): `buy` → `gte`, `sell` → `lte`. Returned on the stop-loss leg.
     */
    #[JsonProperty('activation_condition')]
    public ?string $activationCondition;

    /**
     * @var ?int $activated Activation status (0 - not activated, 1 - activated). Returned on the stop-loss leg
     */
    #[JsonProperty('activated')]
    public ?int $activated;

    /**
     * @param array{
     *   orderId?: ?int,
     *   clientOrderId?: ?string,
     *   market?: ?string,
     *   side?: ?value-of<OcoOrderLegSide>,
     *   type?: ?string,
     *   timestamp?: ?float,
     *   dealMoney?: ?string,
     *   dealStock?: ?string,
     *   amount?: ?string,
     *   left?: ?string,
     *   dealFee?: ?string,
     *   postOnly?: ?bool,
     *   feeAsset?: ?string,
     *   status?: ?string,
     *   stp?: ?string,
     *   positionSide?: ?value-of<OcoOrderLegPositionSide>,
     *   reduceOnly?: ?bool,
     *   mtime?: ?float,
     *   price?: ?string,
     *   activationPrice?: ?string,
     *   activationCondition?: ?value-of<OcoOrderLegActivationCondition>,
     *   activated?: ?int,
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
        $this->left = $values['left'] ?? null;
        $this->dealFee = $values['dealFee'] ?? null;
        $this->postOnly = $values['postOnly'] ?? null;
        $this->feeAsset = $values['feeAsset'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->stp = $values['stp'] ?? null;
        $this->positionSide = $values['positionSide'] ?? null;
        $this->reduceOnly = $values['reduceOnly'] ?? null;
        $this->mtime = $values['mtime'] ?? null;
        $this->price = $values['price'] ?? null;
        $this->activationPrice = $values['activationPrice'] ?? null;
        $this->activationCondition = $values['activationCondition'] ?? null;
        $this->activated = $values['activated'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

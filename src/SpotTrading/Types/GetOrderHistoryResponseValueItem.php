<?php

namespace Whitebit\SpotTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetOrderHistoryResponseValueItem extends JsonSerializableType
{
    /**
     * @var ?string $amount Order quantity in base currency for limit orders, or in quote currency for buy market orders.
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?string $price Limit price per unit in quote currency. Returns `"0"` for market orders.
     */
    #[JsonProperty('price')]
    public ?string $price;

    /**
     * @var ?string $type Order type. Possible values: `limit`, `market`, `stock market`, `stop limit`, `stop market`.
     */
    #[JsonProperty('type')]
    public ?string $type;

    /**
     * @var ?int $id Unique order identifier assigned by the matching engine.
     */
    #[JsonProperty('id')]
    public ?int $id;

    /**
     * @var ?string $clientOrderId Custom client order identifier supplied in the request. Returns an empty string when not specified.
     */
    #[JsonProperty('clientOrderId')]
    public ?string $clientOrderId;

    /**
     * @var ?value-of<GetOrderHistoryResponseValueItemSide> $side Order side. Possible values: `buy`, `sell`.
     */
    #[JsonProperty('side')]
    public ?string $side;

    /**
     * @var ?float $ctime Unix timestamp in seconds (UTC) of order creation, with microsecond precision.
     */
    #[JsonProperty('ctime')]
    public ?float $ctime;

    /**
     * @var ?float $ftime Unix timestamp when the order reached its final status (FILLED or CANCELLED). For partially-filled orders that are subsequently cancelled, the timestamp reflects the cancellation time, not the last fill time.
     */
    #[JsonProperty('ftime')]
    public ?float $ftime;

    /**
     * @var ?string $dealFee Cumulative trading fee charged for filled portions, denominated in the fee asset.
     */
    #[JsonProperty('dealFee')]
    public ?string $dealFee;

    /**
     * @var ?string $dealStock Filled amount in base (stock) currency.
     */
    #[JsonProperty('dealStock')]
    public ?string $dealStock;

    /**
     * @var ?string $dealMoney Filled amount in quote (money) currency.
     */
    #[JsonProperty('dealMoney')]
    public ?string $dealMoney;

    /**
     * @var ?bool $postOnly Post-only flag. When `true`, the order executed only as a maker order.
     */
    #[JsonProperty('postOnly')]
    public ?bool $postOnly;

    /**
     * @var ?bool $ioc Immediate-or-cancel flag. When `true`, the order executed available quantity immediately and cancelled the rest.
     */
    #[JsonProperty('ioc')]
    public ?bool $ioc;

    /**
     * @var ?int $activated Stop/conditional orders only — Unix timestamp at which the trigger price was reached and the order was activated. Absent for unconditional orders.
     */
    #[JsonProperty('activated')]
    public ?int $activated;

    /**
     * @var ?string $activationPrice Stop/conditional orders only — the trigger price that, when reached, activates the order. Absent for unconditional orders.
     */
    #[JsonProperty('activationPrice')]
    public ?string $activationPrice;

    /**
     * @var ?string $activationCondition Stop/conditional orders only — comparison operator that decides when `activationPrice` is met. Absent for unconditional orders.
     */
    #[JsonProperty('activationCondition')]
    public ?string $activationCondition;

    /**
     * @var ?string $status
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var ?string $feeAsset Currency ticker of the asset used to pay the trading fee.
     */
    #[JsonProperty('feeAsset')]
    public ?string $feeAsset;

    /**
     * @var ?string $positionSide Position side for futures/margin orders. Omitted for spot orders without position context.
     */
    #[JsonProperty('positionSide')]
    public ?string $positionSide;

    /**
     * @var ?bool $rpi Retail Price Improvement flag. `true` when the order used RPI pricing.
     */
    #[JsonProperty('rpi')]
    public ?bool $rpi;

    /**
     * @var ?bool $reduceOnly Reduce-only flag. When `true`, the order could only reduce or close an existing position. See [reduce-only](/glossary#reduce-only).
     */
    #[JsonProperty('reduceOnly')]
    public ?bool $reduceOnly;

    /**
     * @param array{
     *   amount?: ?string,
     *   price?: ?string,
     *   type?: ?string,
     *   id?: ?int,
     *   clientOrderId?: ?string,
     *   side?: ?value-of<GetOrderHistoryResponseValueItemSide>,
     *   ctime?: ?float,
     *   ftime?: ?float,
     *   dealFee?: ?string,
     *   dealStock?: ?string,
     *   dealMoney?: ?string,
     *   postOnly?: ?bool,
     *   ioc?: ?bool,
     *   activated?: ?int,
     *   activationPrice?: ?string,
     *   activationCondition?: ?string,
     *   status?: ?string,
     *   feeAsset?: ?string,
     *   positionSide?: ?string,
     *   rpi?: ?bool,
     *   reduceOnly?: ?bool,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->amount = $values['amount'] ?? null;
        $this->price = $values['price'] ?? null;
        $this->type = $values['type'] ?? null;
        $this->id = $values['id'] ?? null;
        $this->clientOrderId = $values['clientOrderId'] ?? null;
        $this->side = $values['side'] ?? null;
        $this->ctime = $values['ctime'] ?? null;
        $this->ftime = $values['ftime'] ?? null;
        $this->dealFee = $values['dealFee'] ?? null;
        $this->dealStock = $values['dealStock'] ?? null;
        $this->dealMoney = $values['dealMoney'] ?? null;
        $this->postOnly = $values['postOnly'] ?? null;
        $this->ioc = $values['ioc'] ?? null;
        $this->activated = $values['activated'] ?? null;
        $this->activationPrice = $values['activationPrice'] ?? null;
        $this->activationCondition = $values['activationCondition'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->feeAsset = $values['feeAsset'] ?? null;
        $this->positionSide = $values['positionSide'] ?? null;
        $this->rpi = $values['rpi'] ?? null;
        $this->reduceOnly = $values['reduceOnly'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

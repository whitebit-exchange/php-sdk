<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Shared order shape returned by the order-creation, cancel, active-orders list, and modify endpoints. Field presence varies by endpoint and order type — see the per-field notes.
 */
class OrderResponse extends JsonSerializableType
{
    /**
     * @var ?int $orderId Unique identifier assigned to the order by the matching engine.
     */
    #[JsonProperty('orderId')]
    public ?int $orderId;

    /**
     * @var ?string $clientOrderId Custom client order identifier supplied in the request. Returns an empty string when not specified.
     */
    #[JsonProperty('clientOrderId')]
    public ?string $clientOrderId;

    /**
     * @var ?string $market Trading pair for the order. Format: `BASE_QUOTE` (e.g., `BTC_USDT`).
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?string $side Order side. Possible values: `buy`, `sell`.
     */
    #[JsonProperty('side')]
    public ?string $side;

    /**
     * @var ?string $type Order type. Possible values: `limit`, `market`, `stock market`, `stop limit`, `stop market`.
     */
    #[JsonProperty('type')]
    public ?string $type;

    /**
     * @var ?float $timestamp Unix timestamp in seconds (UTC) of order creation, with microsecond precision.
     */
    #[JsonProperty('timestamp')]
    public ?float $timestamp;

    /**
     * @var ?string $dealMoney Filled amount in quote currency. Returns `"0"` while the order remains unfilled.
     */
    #[JsonProperty('dealMoney')]
    public ?string $dealMoney;

    /**
     * @var ?string $dealStock Filled amount in base currency. Returns `"0"` while the order remains unfilled.
     */
    #[JsonProperty('dealStock')]
    public ?string $dealStock;

    /**
     * @var ?string $amount Order quantity in base currency for limit and stop-limit orders, or in quote currency for buy market orders.
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?string $left Remaining unfilled quantity. Equals `amount` for new orders and `"0"` for fully filled orders.
     */
    #[JsonProperty('left')]
    public ?string $left;

    /**
     * @var ?string $dealFee Cumulative trading fee charged for filled portions, denominated in the fee asset.
     */
    #[JsonProperty('dealFee')]
    public ?string $dealFee;

    /**
     * @var ?string $feeAsset Currency ticker of the asset used to pay the trading fee. Omitted when empty.
     */
    #[JsonProperty('feeAsset')]
    public ?string $feeAsset;

    /**
     * @var ?string $price Limit price per unit in quote currency. Present for orders that carry a price (limit and stop-limit shapes); omitted on market and stop-market order shapes.
     */
    #[JsonProperty('price')]
    public ?string $price;

    /**
     * @var ?bool $postOnly Post-only flag. When `true`, the order executes only as a maker order and is rejected if it would match immediately. Omitted when not set.
     */
    #[JsonProperty('postOnly')]
    public ?bool $postOnly;

    /**
     * @var ?bool $ioc Immediate-or-cancel flag. When `true`, the order executes available quantity immediately and cancels the unfilled remainder. Default: `false`.
     */
    #[JsonProperty('ioc')]
    public ?bool $ioc;

    /**
     * @var ?string $status
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var ?string $stp Self-trade prevention mode applied to the order. Possible values: `no`, `cb`, `cn`, `co`. The response always returns the abbreviated form, even when the request used a legacy value. Default: `no`.
     */
    #[JsonProperty('stp')]
    public ?string $stp;

    /**
     * @var ?string $positionSide Position side (for collateral orders). Returned on the cancel, active-orders list, and modify responses; omitted when not set. Spot order-creation responses do not include the field.
     */
    #[JsonProperty('positionSide')]
    public ?string $positionSide;

    /**
     * @var ?OrderResponseOto $oto OTO order data. Present only when the order belongs to an [OTO](/glossary#one-triggers-the-other-oto) group — returned on the cancel, active-orders list, and modify responses.
     */
    #[JsonProperty('oto')]
    public ?OrderResponseOto $oto;

    /**
     * @var ?bool $rpi Indicates Retail Price Improvement (RPI) mode for the order.
     */
    #[JsonProperty('rpi')]
    public ?bool $rpi;

    /**
     * @var ?bool $retail Retail-source taker flag. The field is present only when the order was placed with `retail=true`. See [Retail flag](/glossary#retail-flag).
     */
    #[JsonProperty('retail')]
    public ?bool $retail;

    /**
     * @var ?bool $reduceOnly Reduce-only flag. When `true`, the order can only reduce or close an existing position. Returned on the cancel, active-orders list, and modify responses; spot order-creation responses do not include the field. See [reduce-only](/glossary#reduce-only).
     */
    #[JsonProperty('reduceOnly')]
    public ?bool $reduceOnly;

    /**
     * @var ?int $activated Activation status of the stop order. 0 = not yet triggered (waiting for the activation_price condition to be met). 1 = triggered (the stop condition has been met and the order is now active). Returned for stop orders; omitted on other order shapes.
     */
    #[JsonProperty('activated')]
    public ?int $activated;

    /**
     * Trigger condition for the stop order. Response-only — not accepted in the request body, and cannot be overridden. Derived from `side`:
     *
     * - `side = buy` → `gte`. The order activates when the market price rises to or above `activation_price`.
     * - `side = sell` → `lte`. The order activates when the market price falls to or below `activation_price`.
     *
     * @var ?value-of<OrderResponseActivationCondition> $activationCondition
     */
    #[JsonProperty('activationCondition')]
    public ?string $activationCondition;

    /**
     * @var ?string $activationPrice The trigger price for the stop order. Always equals the activation_price value submitted in the request. Returned for stop orders; omitted on other order shapes.
     */
    #[JsonProperty('activation_price')]
    public ?string $activationPrice;

    /**
     * @param array{
     *   orderId?: ?int,
     *   clientOrderId?: ?string,
     *   market?: ?string,
     *   side?: ?string,
     *   type?: ?string,
     *   timestamp?: ?float,
     *   dealMoney?: ?string,
     *   dealStock?: ?string,
     *   amount?: ?string,
     *   left?: ?string,
     *   dealFee?: ?string,
     *   feeAsset?: ?string,
     *   price?: ?string,
     *   postOnly?: ?bool,
     *   ioc?: ?bool,
     *   status?: ?string,
     *   stp?: ?string,
     *   positionSide?: ?string,
     *   oto?: ?OrderResponseOto,
     *   rpi?: ?bool,
     *   retail?: ?bool,
     *   reduceOnly?: ?bool,
     *   activated?: ?int,
     *   activationCondition?: ?value-of<OrderResponseActivationCondition>,
     *   activationPrice?: ?string,
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
        $this->feeAsset = $values['feeAsset'] ?? null;
        $this->price = $values['price'] ?? null;
        $this->postOnly = $values['postOnly'] ?? null;
        $this->ioc = $values['ioc'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->stp = $values['stp'] ?? null;
        $this->positionSide = $values['positionSide'] ?? null;
        $this->oto = $values['oto'] ?? null;
        $this->rpi = $values['rpi'] ?? null;
        $this->retail = $values['retail'] ?? null;
        $this->reduceOnly = $values['reduceOnly'] ?? null;
        $this->activated = $values['activated'] ?? null;
        $this->activationCondition = $values['activationCondition'] ?? null;
        $this->activationPrice = $values['activationPrice'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Types\ActiveOrderStatus;

/**
 * Order data when successful, null when failed
 */
class CreateCollateralBulkOrderResponseItemResult extends JsonSerializableType
{
    /**
     * @var ?int $orderId Unique order identifier
     */
    #[JsonProperty('orderId')]
    public ?int $orderId;

    /**
     * @var ?string $clientOrderId Custom client order identifier. Empty string if not specified
     */
    #[JsonProperty('clientOrderId')]
    public ?string $clientOrderId;

    /**
     * @var ?string $market Market name
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?value-of<CreateCollateralBulkOrderResponseItemResultSide> $side Order side
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
     * @var ?string $dealMoney Amount in money currency that is finished
     */
    #[JsonProperty('dealMoney')]
    public ?string $dealMoney;

    /**
     * @var ?string $dealStock Amount in stock currency that is finished
     */
    #[JsonProperty('dealStock')]
    public ?string $dealStock;

    /**
     * @var ?string $amount Order amount
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?string $left Remaining amount that must be finished
     */
    #[JsonProperty('left')]
    public ?string $left;

    /**
     * @var ?string $dealFee Fee in money that is paid when order is finished
     */
    #[JsonProperty('dealFee')]
    public ?string $dealFee;

    /**
     * @var ?string $price Order price
     */
    #[JsonProperty('price')]
    public ?string $price;

    /**
     * @var ?bool $postOnly Post-only flag
     */
    #[JsonProperty('postOnly')]
    public ?bool $postOnly;

    /**
     * @var ?bool $ioc Immediate or cancel flag
     */
    #[JsonProperty('ioc')]
    public ?bool $ioc;

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
     * @var ?value-of<CreateCollateralBulkOrderResponseItemResultPositionSide> $positionSide Position side
     */
    #[JsonProperty('positionSide')]
    public ?string $positionSide;

    /**
     * @var ?bool $rpi Retail Price Improvement flag
     */
    #[JsonProperty('rpi')]
    public ?bool $rpi;

    /**
     * @var ?bool $reduceOnly Reduce-only flag
     */
    #[JsonProperty('reduceOnly')]
    public ?bool $reduceOnly;

    /**
     * @param array{
     *   orderId?: ?int,
     *   clientOrderId?: ?string,
     *   market?: ?string,
     *   side?: ?value-of<CreateCollateralBulkOrderResponseItemResultSide>,
     *   type?: ?string,
     *   timestamp?: ?float,
     *   dealMoney?: ?string,
     *   dealStock?: ?string,
     *   amount?: ?string,
     *   left?: ?string,
     *   dealFee?: ?string,
     *   price?: ?string,
     *   postOnly?: ?bool,
     *   ioc?: ?bool,
     *   status?: ?value-of<ActiveOrderStatus>,
     *   stp?: ?string,
     *   positionSide?: ?value-of<CreateCollateralBulkOrderResponseItemResultPositionSide>,
     *   rpi?: ?bool,
     *   reduceOnly?: ?bool,
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
        $this->price = $values['price'] ?? null;
        $this->postOnly = $values['postOnly'] ?? null;
        $this->ioc = $values['ioc'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->stp = $values['stp'] ?? null;
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

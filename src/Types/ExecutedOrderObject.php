<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Executed order object
 */
class ExecutedOrderObject extends JsonSerializableType
{
    /**
     * @var ?int $id Order ID
     */
    #[JsonProperty('id')]
    public ?int $id;

    /**
     * @var ?float $ctime Created at in Unix time
     */
    #[JsonProperty('ctime')]
    public ?float $ctime;

    /**
     * @var ?float $ftime Finished at in Unix time
     */
    #[JsonProperty('ftime')]
    public ?float $ftime;

    /**
     * @var ?float $mtime Modified at in Unix time
     */
    #[JsonProperty('mtime')]
    public ?float $mtime;

    /**
     * @var ?string $market [Market](/glossary#market)
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?string $source Source (e.g., web, api)
     */
    #[JsonProperty('source')]
    public ?string $source;

    /**
     * @var ?int $type Order type. See order types table in overview
     */
    #[JsonProperty('type')]
    public ?int $type;

    /**
     * @var ?int $side Side: 1=sell, 2=buy/bid
     */
    #[JsonProperty('side')]
    public ?int $side;

    /**
     * @var ?bool $postOnly Post only flag
     */
    #[JsonProperty('post_only')]
    public ?bool $postOnly;

    /**
     * @var ?bool $ioc IOC flag
     */
    #[JsonProperty('ioc')]
    public ?bool $ioc;

    /**
     * @var ?string $price Order price
     */
    #[JsonProperty('price')]
    public ?string $price;

    /**
     * @var ?string $amount [Stock](/glossary#stock) amount
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?string $left Stock amount remaining to be executed
     */
    #[JsonProperty('left')]
    public ?string $left;

    /**
     * @var ?string $dealStock Executed stock amount
     */
    #[JsonProperty('deal_stock')]
    public ?string $dealStock;

    /**
     * @var ?string $dealMoney Executed [Money](/glossary#money) amount
     */
    #[JsonProperty('deal_money')]
    public ?string $dealMoney;

    /**
     * @var ?string $dealFee Charged fee amount in money
     */
    #[JsonProperty('deal_fee')]
    public ?string $dealFee;

    /**
     * @var ?string $clientOrderId Custom client order id
     */
    #[JsonProperty('client_order_id')]
    public ?string $clientOrderId;

    /**
     * @var ?value-of<ExecutedOrderObjectStp> $stp STP flag: no=No Prevention, co=Cancel Oldest, cn=Cancel Newest, cb=Cancel Both
     */
    #[JsonProperty('stp')]
    public ?string $stp;

    /**
     * @var ?string $status Order status (e.g., FILLED, CANCELED)
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var ?value-of<ExecutedOrderObjectPositionSide> $positionSide Position side - LONG or SHORT or BOTH
     */
    #[JsonProperty('position_side')]
    public ?string $positionSide;

    /**
     * @var ?bool $rpi Indicates Retail Price Improvement (RPI) mode for the order.
     */
    #[JsonProperty('rpi')]
    public ?bool $rpi;

    /**
     * @var ?string $feeAsset Fee asset type
     */
    #[JsonProperty('fee_asset')]
    public ?string $feeAsset;

    /**
     * @param array{
     *   id?: ?int,
     *   ctime?: ?float,
     *   ftime?: ?float,
     *   mtime?: ?float,
     *   market?: ?string,
     *   source?: ?string,
     *   type?: ?int,
     *   side?: ?int,
     *   postOnly?: ?bool,
     *   ioc?: ?bool,
     *   price?: ?string,
     *   amount?: ?string,
     *   left?: ?string,
     *   dealStock?: ?string,
     *   dealMoney?: ?string,
     *   dealFee?: ?string,
     *   clientOrderId?: ?string,
     *   stp?: ?value-of<ExecutedOrderObjectStp>,
     *   status?: ?string,
     *   positionSide?: ?value-of<ExecutedOrderObjectPositionSide>,
     *   rpi?: ?bool,
     *   feeAsset?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->id = $values['id'] ?? null;
        $this->ctime = $values['ctime'] ?? null;
        $this->ftime = $values['ftime'] ?? null;
        $this->mtime = $values['mtime'] ?? null;
        $this->market = $values['market'] ?? null;
        $this->source = $values['source'] ?? null;
        $this->type = $values['type'] ?? null;
        $this->side = $values['side'] ?? null;
        $this->postOnly = $values['postOnly'] ?? null;
        $this->ioc = $values['ioc'] ?? null;
        $this->price = $values['price'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->left = $values['left'] ?? null;
        $this->dealStock = $values['dealStock'] ?? null;
        $this->dealMoney = $values['dealMoney'] ?? null;
        $this->dealFee = $values['dealFee'] ?? null;
        $this->clientOrderId = $values['clientOrderId'] ?? null;
        $this->stp = $values['stp'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->positionSide = $values['positionSide'] ?? null;
        $this->rpi = $values['rpi'] ?? null;
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

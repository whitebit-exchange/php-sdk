<?php

namespace Whitebit\SpotTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetOrderDealsResponseRecordsItem extends JsonSerializableType
{
    /**
     * @var ?float $time Unix timestamp of the deal execution, with microsecond precision.
     */
    #[JsonProperty('time')]
    public ?float $time;

    /**
     * @var ?string $fee Fee charged for the deal, denominated in the asset specified by `feeAsset`.
     */
    #[JsonProperty('fee')]
    public ?string $fee;

    /**
     * @var ?string $price Execution price per unit in quote currency.
     */
    #[JsonProperty('price')]
    public ?string $price;

    /**
     * @var ?string $amount Executed quantity in base (stock) currency.
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?int $id Unique deal identifier assigned by the matching engine.
     */
    #[JsonProperty('id')]
    public ?int $id;

    /**
     * @var ?int $dealOrderId Identifier of the counterparty order that matched against the queried order.
     */
    #[JsonProperty('dealOrderId')]
    public ?int $dealOrderId;

    /**
     * @var ?string $clientOrderId Custom order identifier supplied in the original order request. Returns an empty string when not specified.
     */
    #[JsonProperty('clientOrderId')]
    public ?string $clientOrderId;

    /**
     * @var ?int $role Execution role in the deal. `1` = maker (order was resting on the book), `2` = taker (order matched immediately).
     */
    #[JsonProperty('role')]
    public ?int $role;

    /**
     * @var ?string $deal Total deal value in quote (money) currency. Equals `amount * price`.
     */
    #[JsonProperty('deal')]
    public ?string $deal;

    /**
     * @var ?string $feeAsset Currency ticker of the asset used to pay the trading fee.
     */
    #[JsonProperty('feeAsset')]
    public ?string $feeAsset;

    /**
     * @var ?bool $rpi Retail Price Improvement flag. `true` when the deal executed under RPI pricing.
     */
    #[JsonProperty('rpi')]
    public ?bool $rpi;

    /**
     * @param array{
     *   time?: ?float,
     *   fee?: ?string,
     *   price?: ?string,
     *   amount?: ?string,
     *   id?: ?int,
     *   dealOrderId?: ?int,
     *   clientOrderId?: ?string,
     *   role?: ?int,
     *   deal?: ?string,
     *   feeAsset?: ?string,
     *   rpi?: ?bool,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->time = $values['time'] ?? null;
        $this->fee = $values['fee'] ?? null;
        $this->price = $values['price'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->id = $values['id'] ?? null;
        $this->dealOrderId = $values['dealOrderId'] ?? null;
        $this->clientOrderId = $values['clientOrderId'] ?? null;
        $this->role = $values['role'] ?? null;
        $this->deal = $values['deal'] ?? null;
        $this->feeAsset = $values['feeAsset'] ?? null;
        $this->rpi = $values['rpi'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

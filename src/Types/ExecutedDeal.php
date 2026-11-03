<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class ExecutedDeal extends JsonSerializableType
{
    /**
     * @var ?int $id Unique deal identifier assigned by the matching engine.
     */
    #[JsonProperty('id')]
    public ?int $id;

    /**
     * @var ?string $clientOrderId Custom order identifier supplied in the original order request. Returns an empty string when not specified.
     */
    #[JsonProperty('clientOrderId')]
    public ?string $clientOrderId;

    /**
     * @var ?float $time Unix timestamp of the deal execution, with microsecond precision.
     */
    #[JsonProperty('time')]
    public ?float $time;

    /**
     * @var ?value-of<ExecutedDealSide> $side Order side that produced the deal. Possible values: `buy`, `sell`.
     */
    #[JsonProperty('side')]
    public ?string $side;

    /**
     * @var ?int $role Execution role in the deal. `1` = maker (order was resting on the book), `2` = taker (order matched immediately).
     */
    #[JsonProperty('role')]
    public ?int $role;

    /**
     * @var ?string $amount Executed quantity in base (stock) currency, regardless of order direction.
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?string $price Execution price per unit in quote currency.
     */
    #[JsonProperty('price')]
    public ?string $price;

    /**
     * @var ?string $deal Total deal value in quote (money) currency. Equals `amount * price`.
     */
    #[JsonProperty('deal')]
    public ?string $deal;

    /**
     * @var ?string $fee Fee charged for the deal, denominated in the asset specified by `feeAsset`.
     */
    #[JsonProperty('fee')]
    public ?string $fee;

    /**
     * @var ?int $orderId Identifier of the parent order that produced the deal.
     */
    #[JsonProperty('orderId')]
    public ?int $orderId;

    /**
     * @var ?string $feeAsset Currency ticker of the asset used to pay the trading fee.
     */
    #[JsonProperty('feeAsset')]
    public ?string $feeAsset;

    /**
     * @param array{
     *   id?: ?int,
     *   clientOrderId?: ?string,
     *   time?: ?float,
     *   side?: ?value-of<ExecutedDealSide>,
     *   role?: ?int,
     *   amount?: ?string,
     *   price?: ?string,
     *   deal?: ?string,
     *   fee?: ?string,
     *   orderId?: ?int,
     *   feeAsset?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->id = $values['id'] ?? null;
        $this->clientOrderId = $values['clientOrderId'] ?? null;
        $this->time = $values['time'] ?? null;
        $this->side = $values['side'] ?? null;
        $this->role = $values['role'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->price = $values['price'] ?? null;
        $this->deal = $values['deal'] ?? null;
        $this->fee = $values['fee'] ?? null;
        $this->orderId = $values['orderId'] ?? null;
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

<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class Trade extends JsonSerializableType
{
    /**
     * @var int $id Trade ID
     */
    #[JsonProperty('id')]
    public int $id;

    /**
     * @var float $time Trade time (Unix timestamp with milliseconds)
     */
    #[JsonProperty('time')]
    public float $time;

    /**
     * @var string $price Trade price
     */
    #[JsonProperty('price')]
    public string $price;

    /**
     * @var string $amount Trade amount
     */
    #[JsonProperty('amount')]
    public string $amount;

    /**
     * @var value-of<TradeType> $type Trade type (buy/sell)
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var ?bool $rpi Indicates whether the trade involved a Retail Price Improvement (RPI) order
     */
    #[JsonProperty('rpi')]
    public ?bool $rpi;

    /**
     * @param array{
     *   id: int,
     *   time: float,
     *   price: string,
     *   amount: string,
     *   type: value-of<TradeType>,
     *   rpi?: ?bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'];
        $this->time = $values['time'];
        $this->price = $values['price'];
        $this->amount = $values['amount'];
        $this->type = $values['type'];
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

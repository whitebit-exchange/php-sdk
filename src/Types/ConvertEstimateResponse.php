<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class ConvertEstimateResponse extends JsonSerializableType
{
    /**
     * @var ?string $id Quote ID
     */
    #[JsonProperty('id')]
    public ?string $id;

    /**
     * @var ?string $from From currency
     */
    #[JsonProperty('from')]
    public ?string $from;

    /**
     * @var ?string $to To currency
     */
    #[JsonProperty('to')]
    public ?string $to;

    /**
     * @var ?string $give Amount to give
     */
    #[JsonProperty('give')]
    public ?string $give;

    /**
     * @var ?string $receive Amount to receive
     */
    #[JsonProperty('receive')]
    public ?string $receive;

    /**
     * @var ?string $rate Conversion rate expressed in the from→to direction: units of the 'to' currency received per one unit of the 'from' currency. Example: if from=BTC and to=USDT, a rate of "34299.76" means 1 BTC is worth approximately 34 299.76 USDT at the time of the quote.
     */
    #[JsonProperty('rate')]
    public ?string $rate;

    /**
     * @var ?int $expireAt Quote expiration timestamp
     */
    #[JsonProperty('expireAt')]
    public ?int $expireAt;

    /**
     * @param array{
     *   id?: ?string,
     *   from?: ?string,
     *   to?: ?string,
     *   give?: ?string,
     *   receive?: ?string,
     *   rate?: ?string,
     *   expireAt?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->id = $values['id'] ?? null;
        $this->from = $values['from'] ?? null;
        $this->to = $values['to'] ?? null;
        $this->give = $values['give'] ?? null;
        $this->receive = $values['receive'] ?? null;
        $this->rate = $values['rate'] ?? null;
        $this->expireAt = $values['expireAt'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

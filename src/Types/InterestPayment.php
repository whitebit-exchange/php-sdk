<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class InterestPayment extends JsonSerializableType
{
    /**
     * @var ?string $planId Invest plan identifier
     */
    #[JsonProperty('planId')]
    public ?string $planId;

    /**
     * @var ?string $investmentId Investment identifier
     */
    #[JsonProperty('investmentId')]
    public ?string $investmentId;

    /**
     * @var ?string $amount Interest amount
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?string $ticker Interest currency [ticker](/glossary#ticker)
     */
    #[JsonProperty('ticker')]
    public ?string $ticker;

    /**
     * @var ?int $timestamp Transaction timestamp
     */
    #[JsonProperty('timestamp')]
    public ?int $timestamp;

    /**
     * @param array{
     *   planId?: ?string,
     *   investmentId?: ?string,
     *   amount?: ?string,
     *   ticker?: ?string,
     *   timestamp?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->planId = $values['planId'] ?? null;
        $this->investmentId = $values['investmentId'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->ticker = $values['ticker'] ?? null;
        $this->timestamp = $values['timestamp'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

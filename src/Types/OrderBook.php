<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class OrderBook extends JsonSerializableType
{
    /**
     * @var float $timestamp Timestamp from matchengine
     */
    #[JsonProperty('timestamp')]
    public float $timestamp;

    /**
     * @var array<array<mixed>> $asks Asks sorted ascending
     */
    #[JsonProperty('asks'), ArrayType([['mixed']])]
    public array $asks;

    /**
     * @var array<array<mixed>> $bids Bids sorted descending
     */
    #[JsonProperty('bids'), ArrayType([['mixed']])]
    public array $bids;

    /**
     * @param array{
     *   timestamp: float,
     *   asks: array<array<mixed>>,
     *   bids: array<array<mixed>>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->timestamp = $values['timestamp'];
        $this->asks = $values['asks'];
        $this->bids = $values['bids'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

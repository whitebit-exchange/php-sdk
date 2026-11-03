<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class OrderbookResponse extends JsonSerializableType
{
    /**
     * @var ?string $tickerId Market Name
     */
    #[JsonProperty('ticker_id')]
    public ?string $tickerId;

    /**
     * @var ?int $timestamp Current timestamp
     */
    #[JsonProperty('timestamp')]
    public ?int $timestamp;

    /**
     * @var ?array<array<string>> $asks Array of ask orders
     */
    #[JsonProperty('asks'), ArrayType([['string']])]
    public ?array $asks;

    /**
     * @var ?array<array<string>> $bids Array of bid orders
     */
    #[JsonProperty('bids'), ArrayType([['string']])]
    public ?array $bids;

    /**
     * @param array{
     *   tickerId?: ?string,
     *   timestamp?: ?int,
     *   asks?: ?array<array<string>>,
     *   bids?: ?array<array<string>>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->tickerId = $values['tickerId'] ?? null;
        $this->timestamp = $values['timestamp'] ?? null;
        $this->asks = $values['asks'] ?? null;
        $this->bids = $values['bids'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class DepthUpdateData extends JsonSerializableType
{
    /**
     * @var float $timestamp Timestamp from matchengine
     */
    #[JsonProperty('timestamp')]
    public float $timestamp;

    /**
     * @var ?int $updateId Update ID
     */
    #[JsonProperty('update_id')]
    public ?int $updateId;

    /**
     * @var ?int $pastUpdateId Previous update ID (present in incremental updates only, not in first snapshot)
     */
    #[JsonProperty('past_update_id')]
    public ?int $pastUpdateId;

    /**
     * @var array<array<mixed>> $asks
     */
    #[JsonProperty('asks'), ArrayType([['mixed']])]
    public array $asks;

    /**
     * @var array<array<mixed>> $bids
     */
    #[JsonProperty('bids'), ArrayType([['mixed']])]
    public array $bids;

    /**
     * @var float $eventTime Event time
     */
    #[JsonProperty('event_time')]
    public float $eventTime;

    /**
     * @param array{
     *   timestamp: float,
     *   asks: array<array<mixed>>,
     *   bids: array<array<mixed>>,
     *   eventTime: float,
     *   updateId?: ?int,
     *   pastUpdateId?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->timestamp = $values['timestamp'];
        $this->updateId = $values['updateId'] ?? null;
        $this->pastUpdateId = $values['pastUpdateId'] ?? null;
        $this->asks = $values['asks'];
        $this->bids = $values['bids'];
        $this->eventTime = $values['eventTime'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

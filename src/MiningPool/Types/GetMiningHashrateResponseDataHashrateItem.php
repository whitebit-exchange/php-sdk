<?php

namespace Whitebit\MiningPool\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetMiningHashrateResponseDataHashrateItem extends JsonSerializableType
{
    /**
     * @var ?int $timestamp
     */
    #[JsonProperty('timestamp')]
    public ?int $timestamp;

    /**
     * @var ?string $hashrate
     */
    #[JsonProperty('hashrate')]
    public ?string $hashrate;

    /**
     * @var ?float $rejectRate Share reject rate (e.g. `0.01` means 1%)
     */
    #[JsonProperty('rejectRate')]
    public ?float $rejectRate;

    /**
     * @param array{
     *   timestamp?: ?int,
     *   hashrate?: ?string,
     *   rejectRate?: ?float,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->timestamp = $values['timestamp'] ?? null;
        $this->hashrate = $values['hashrate'] ?? null;
        $this->rejectRate = $values['rejectRate'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

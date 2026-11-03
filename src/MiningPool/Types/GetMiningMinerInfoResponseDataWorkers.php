<?php

namespace Whitebit\MiningPool\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Worker counts grouped by status
 */
class GetMiningMinerInfoResponseDataWorkers extends JsonSerializableType
{
    /**
     * @var ?int $online Number of online workers
     */
    #[JsonProperty('online')]
    public ?int $online;

    /**
     * @var ?int $offline Number of offline workers
     */
    #[JsonProperty('offline')]
    public ?int $offline;

    /**
     * @var ?int $low Number of low-hashrate workers
     */
    #[JsonProperty('low')]
    public ?int $low;

    /**
     * @param array{
     *   online?: ?int,
     *   offline?: ?int,
     *   low?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->online = $values['online'] ?? null;
        $this->offline = $values['offline'] ?? null;
        $this->low = $values['low'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

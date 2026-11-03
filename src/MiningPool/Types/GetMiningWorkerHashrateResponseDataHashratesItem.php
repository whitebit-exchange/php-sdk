<?php

namespace Whitebit\MiningPool\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetMiningWorkerHashrateResponseDataHashratesItem extends JsonSerializableType
{
    /**
     * @var ?int $time
     */
    #[JsonProperty('time')]
    public ?int $time;

    /**
     * @var ?string $hashrate Hashrate in TH/s
     */
    #[JsonProperty('hashrate')]
    public ?string $hashrate;

    /**
     * @param array{
     *   time?: ?int,
     *   hashrate?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->time = $values['time'] ?? null;
        $this->hashrate = $values['hashrate'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

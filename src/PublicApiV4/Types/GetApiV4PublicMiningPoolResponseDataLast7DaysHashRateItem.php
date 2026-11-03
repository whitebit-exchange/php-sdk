<?php

namespace Whitebit\PublicApiV4\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetApiV4PublicMiningPoolResponseDataLast7DaysHashRateItem extends JsonSerializableType
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
     * @param array{
     *   timestamp?: ?int,
     *   hashrate?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->timestamp = $values['timestamp'] ?? null;
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

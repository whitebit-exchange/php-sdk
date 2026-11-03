<?php

namespace Whitebit\MiningPool\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetMiningMinerInfoResponseDataStratumItem extends JsonSerializableType
{
    /**
     * @var ?string $url
     */
    #[JsonProperty('url')]
    public ?string $url;

    /**
     * @var ?int $workersCount
     */
    #[JsonProperty('workersCount')]
    public ?int $workersCount;

    /**
     * @param array{
     *   url?: ?string,
     *   workersCount?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->url = $values['url'] ?? null;
        $this->workersCount = $values['workersCount'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

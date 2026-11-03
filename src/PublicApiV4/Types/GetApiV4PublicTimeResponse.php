<?php

namespace Whitebit\PublicApiV4\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetApiV4PublicTimeResponse extends JsonSerializableType
{
    /**
     * @var ?int $time Unix timestamp in seconds
     */
    #[JsonProperty('time')]
    public ?int $time;

    /**
     * @param array{
     *   time?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->time = $values['time'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

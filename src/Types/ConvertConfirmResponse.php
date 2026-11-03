<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class ConvertConfirmResponse extends JsonSerializableType
{
    /**
     * @var ?string $finalGive Final amount given
     */
    #[JsonProperty('finalGive')]
    public ?string $finalGive;

    /**
     * @var ?string $finalReceive Final amount received
     */
    #[JsonProperty('finalReceive')]
    public ?string $finalReceive;

    /**
     * @param array{
     *   finalGive?: ?string,
     *   finalReceive?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->finalGive = $values['finalGive'] ?? null;
        $this->finalReceive = $values['finalReceive'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

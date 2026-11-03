<?php

namespace Whitebit\PublicApiV4\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetApiV4PublicMiningPoolResponseDataBlocksItem extends JsonSerializableType
{
    /**
     * @var ?int $blockFoundAt
     */
    #[JsonProperty('block_found_at')]
    public ?int $blockFoundAt;

    /**
     * @var ?int $blockHeight
     */
    #[JsonProperty('block_height')]
    public ?int $blockHeight;

    /**
     * @param array{
     *   blockFoundAt?: ?int,
     *   blockHeight?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->blockFoundAt = $values['blockFoundAt'] ?? null;
        $this->blockHeight = $values['blockHeight'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

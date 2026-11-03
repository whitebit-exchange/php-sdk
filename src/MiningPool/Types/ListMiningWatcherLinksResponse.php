<?php

namespace Whitebit\MiningPool\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class ListMiningWatcherLinksResponse extends JsonSerializableType
{
    /**
     * @var ?array<ListMiningWatcherLinksResponseDataItem> $data
     */
    #[JsonProperty('data'), ArrayType([ListMiningWatcherLinksResponseDataItem::class])]
    public ?array $data;

    /**
     * @param array{
     *   data?: ?array<ListMiningWatcherLinksResponseDataItem>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->data = $values['data'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

<?php

namespace Whitebit\TravelRule\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class GetTravelRuleVaspsResponseData extends JsonSerializableType
{
    /**
     * @var ?array<GetTravelRuleVaspsResponseDataVaspsItem> $vasps
     */
    #[JsonProperty('vasps'), ArrayType([GetTravelRuleVaspsResponseDataVaspsItem::class])]
    public ?array $vasps;

    /**
     * @param array{
     *   vasps?: ?array<GetTravelRuleVaspsResponseDataVaspsItem>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->vasps = $values['vasps'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

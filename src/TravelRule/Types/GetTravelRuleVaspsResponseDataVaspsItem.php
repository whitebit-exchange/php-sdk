<?php

namespace Whitebit\TravelRule\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetTravelRuleVaspsResponseDataVaspsItem extends JsonSerializableType
{
    /**
     * @var ?string $vaspId Unique VASP identifier to use in travel rule submissions
     */
    #[JsonProperty('vaspId')]
    public ?string $vaspId;

    /**
     * @var ?string $name Human-readable VASP name
     */
    #[JsonProperty('name')]
    public ?string $name;

    /**
     * @param array{
     *   vaspId?: ?string,
     *   name?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->vaspId = $values['vaspId'] ?? null;
        $this->name = $values['name'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

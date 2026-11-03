<?php

namespace Whitebit\TravelRule\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetTravelRuleVaspsResponse extends JsonSerializableType
{
    /**
     * @var ?GetTravelRuleVaspsResponseData $data
     */
    #[JsonProperty('data')]
    public ?GetTravelRuleVaspsResponseData $data;

    /**
     * @param array{
     *   data?: ?GetTravelRuleVaspsResponseData,
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

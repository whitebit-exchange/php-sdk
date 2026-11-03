<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class SubAccountApiKeyAccessEndpointsItem extends JsonSerializableType
{
    /**
     * @var ?string $name Endpoint name
     */
    #[JsonProperty('name')]
    public ?string $name;

    /**
     * @var ?string $title Endpoint title
     */
    #[JsonProperty('title')]
    public ?string $title;

    /**
     * @param array{
     *   name?: ?string,
     *   title?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->name = $values['name'] ?? null;
        $this->title = $values['title'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

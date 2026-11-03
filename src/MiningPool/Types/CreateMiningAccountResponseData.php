<?php

namespace Whitebit\MiningPool\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CreateMiningAccountResponseData extends JsonSerializableType
{
    /**
     * @var ?string $name Created mining account name
     */
    #[JsonProperty('name')]
    public ?string $name;

    /**
     * @var ?int $createdAt Account creation timestamp (Unix time)
     */
    #[JsonProperty('createdAt')]
    public ?int $createdAt;

    /**
     * @param array{
     *   name?: ?string,
     *   createdAt?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->name = $values['name'] ?? null;
        $this->createdAt = $values['createdAt'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

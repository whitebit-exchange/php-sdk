<?php

namespace Whitebit\MiningPool\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CreateMiningWatcherLinkResponseData extends JsonSerializableType
{
    /**
     * @var ?string $id
     */
    #[JsonProperty('id')]
    public ?string $id;

    /**
     * @var ?string $link
     */
    #[JsonProperty('link')]
    public ?string $link;

    /**
     * @var ?int $liveUntil
     */
    #[JsonProperty('liveUntil')]
    public ?int $liveUntil;

    /**
     * @var ?int $createdAt
     */
    #[JsonProperty('createdAt')]
    public ?int $createdAt;

    /**
     * @param array{
     *   id?: ?string,
     *   link?: ?string,
     *   liveUntil?: ?int,
     *   createdAt?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->id = $values['id'] ?? null;
        $this->link = $values['link'] ?? null;
        $this->liveUntil = $values['liveUntil'] ?? null;
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

<?php

namespace Whitebit\MiningPool\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class ListMiningWatcherLinksResponseDataItem extends JsonSerializableType
{
    /**
     * @var ?string $id
     */
    #[JsonProperty('id')]
    public ?string $id;

    /**
     * @var ?array<string> $accounts
     */
    #[JsonProperty('accounts'), ArrayType(['string'])]
    public ?array $accounts;

    /**
     * @var ?string $name
     */
    #[JsonProperty('name')]
    public ?string $name;

    /**
     * @var ?string $link
     */
    #[JsonProperty('link')]
    public ?string $link;

    /**
     * @var ?array<string> $permissions
     */
    #[JsonProperty('permissions'), ArrayType(['string'])]
    public ?array $permissions;

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
     *   accounts?: ?array<string>,
     *   name?: ?string,
     *   link?: ?string,
     *   permissions?: ?array<string>,
     *   liveUntil?: ?int,
     *   createdAt?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->id = $values['id'] ?? null;
        $this->accounts = $values['accounts'] ?? null;
        $this->name = $values['name'] ?? null;
        $this->link = $values['link'] ?? null;
        $this->permissions = $values['permissions'] ?? null;
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

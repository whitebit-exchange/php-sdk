<?php

namespace Whitebit\SubAccountApiKeys\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Types\SubAccountApiKeyList;
use Whitebit\Core\Types\ArrayType;

class ListSubAccountApiKeysResponse extends JsonSerializableType
{
    /**
     * @var ?int $limit
     */
    #[JsonProperty('limit')]
    public ?int $limit;

    /**
     * @var ?int $offset
     */
    #[JsonProperty('offset')]
    public ?int $offset;

    /**
     * @var ?array<SubAccountApiKeyList> $data
     */
    #[JsonProperty('data'), ArrayType([SubAccountApiKeyList::class])]
    public ?array $data;

    /**
     * @param array{
     *   limit?: ?int,
     *   offset?: ?int,
     *   data?: ?array<SubAccountApiKeyList>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->limit = $values['limit'] ?? null;
        $this->offset = $values['offset'] ?? null;
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

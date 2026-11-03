<?php

namespace Whitebit\SubAccount\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Types\SubAccount;
use Whitebit\Core\Types\ArrayType;

class ListSubAccountsResponse extends JsonSerializableType
{
    /**
     * @var ?int $offset
     */
    #[JsonProperty('offset')]
    public ?int $offset;

    /**
     * @var ?int $limit
     */
    #[JsonProperty('limit')]
    public ?int $limit;

    /**
     * @var ?array<SubAccount> $data
     */
    #[JsonProperty('data'), ArrayType([SubAccount::class])]
    public ?array $data;

    /**
     * @param array{
     *   offset?: ?int,
     *   limit?: ?int,
     *   data?: ?array<SubAccount>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->offset = $values['offset'] ?? null;
        $this->limit = $values['limit'] ?? null;
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

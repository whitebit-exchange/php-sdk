<?php

namespace Whitebit\SubAccount\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class ListSubAccountsRequest extends JsonSerializableType
{
    /**
     * @var ?string $search Search term
     */
    #[JsonProperty('search')]
    public ?string $search;

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
     * @param array{
     *   search?: ?string,
     *   limit?: ?int,
     *   offset?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->search = $values['search'] ?? null;
        $this->limit = $values['limit'] ?? null;
        $this->offset = $values['offset'] ?? null;
    }
}

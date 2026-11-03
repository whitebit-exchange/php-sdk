<?php

namespace Whitebit\Codes\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Types\CodeHistory;
use Whitebit\Core\Types\ArrayType;

class GetCodesHistoryResponse extends JsonSerializableType
{
    /**
     * @var ?int $total Total number of code history entries
     */
    #[JsonProperty('total')]
    public ?int $total;

    /**
     * @var ?array<CodeHistory> $data
     */
    #[JsonProperty('data'), ArrayType([CodeHistory::class])]
    public ?array $data;

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
     *   total?: ?int,
     *   data?: ?array<CodeHistory>,
     *   limit?: ?int,
     *   offset?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->total = $values['total'] ?? null;
        $this->data = $values['data'] ?? null;
        $this->limit = $values['limit'] ?? null;
        $this->offset = $values['offset'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

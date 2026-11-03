<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class ConvertHistoryResponse extends JsonSerializableType
{
    /**
     * @var ?array<ConvertHistoryResponseRecordsItem> $records
     */
    #[JsonProperty('records'), ArrayType([ConvertHistoryResponseRecordsItem::class])]
    public ?array $records;

    /**
     * @var ?int $total Total number of records
     */
    #[JsonProperty('total')]
    public ?int $total;

    /**
     * @var ?int $limit Limit used in request
     */
    #[JsonProperty('limit')]
    public ?int $limit;

    /**
     * @var ?int $offset Offset used in request
     */
    #[JsonProperty('offset')]
    public ?int $offset;

    /**
     * @param array{
     *   records?: ?array<ConvertHistoryResponseRecordsItem>,
     *   total?: ?int,
     *   limit?: ?int,
     *   offset?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->records = $values['records'] ?? null;
        $this->total = $values['total'] ?? null;
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

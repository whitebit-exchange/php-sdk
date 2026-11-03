<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class GetConditionalOrdersResponse extends JsonSerializableType
{
    /**
     * @var ?int $limit Number of records per page
     */
    #[JsonProperty('limit')]
    public ?int $limit;

    /**
     * @var ?int $offset Number of records skipped
     */
    #[JsonProperty('offset')]
    public ?int $offset;

    /**
     * @var ?int $total Total number of records
     */
    #[JsonProperty('total')]
    public ?int $total;

    /**
     * @var ?array<GetConditionalOrdersResponseRecordsItem> $records Array of conditional orders (can be OCO or OTO type)
     */
    #[JsonProperty('records'), ArrayType([GetConditionalOrdersResponseRecordsItem::class])]
    public ?array $records;

    /**
     * @param array{
     *   limit?: ?int,
     *   offset?: ?int,
     *   total?: ?int,
     *   records?: ?array<GetConditionalOrdersResponseRecordsItem>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->limit = $values['limit'] ?? null;
        $this->offset = $values['offset'] ?? null;
        $this->total = $values['total'] ?? null;
        $this->records = $values['records'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

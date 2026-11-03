<?php

namespace Whitebit\SpotTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class GetOrderDealsResponse extends JsonSerializableType
{
    /**
     * @var ?array<GetOrderDealsResponseRecordsItem> $records Array of deal records
     */
    #[JsonProperty('records'), ArrayType([GetOrderDealsResponseRecordsItem::class])]
    public ?array $records;

    /**
     * @var ?int $offset Number of records skipped
     */
    #[JsonProperty('offset')]
    public ?int $offset;

    /**
     * @var ?int $limit Number of records per page
     */
    #[JsonProperty('limit')]
    public ?int $limit;

    /**
     * @param array{
     *   records?: ?array<GetOrderDealsResponseRecordsItem>,
     *   offset?: ?int,
     *   limit?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->records = $values['records'] ?? null;
        $this->offset = $values['offset'] ?? null;
        $this->limit = $values['limit'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class DealsResponseResult extends JsonSerializableType
{
    /**
     * @var ?int $limit Limit from request
     */
    #[JsonProperty('limit')]
    public ?int $limit;

    /**
     * @var ?int $offset Offset from request
     */
    #[JsonProperty('offset')]
    public ?int $offset;

    /**
     * @var ?array<DealsResponseResultRecordsItem> $records
     */
    #[JsonProperty('records'), ArrayType([DealsResponseResultRecordsItem::class])]
    public ?array $records;

    /**
     * @param array{
     *   limit?: ?int,
     *   offset?: ?int,
     *   records?: ?array<DealsResponseResultRecordsItem>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->limit = $values['limit'] ?? null;
        $this->offset = $values['offset'] ?? null;
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

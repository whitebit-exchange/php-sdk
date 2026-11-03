<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class PositionsUpdateParams extends JsonSerializableType
{
    /**
     * @var ?int $total Positions count
     */
    #[JsonProperty('total')]
    public ?int $total;

    /**
     * @var ?array<PositionsUpdateParamsRecordsItem> $records
     */
    #[JsonProperty('records'), ArrayType([PositionsUpdateParamsRecordsItem::class])]
    public ?array $records;

    /**
     * @param array{
     *   total?: ?int,
     *   records?: ?array<PositionsUpdateParamsRecordsItem>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
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

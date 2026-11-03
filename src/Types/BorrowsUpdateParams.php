<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class BorrowsUpdateParams extends JsonSerializableType
{
    /**
     * @var ?int $total Borrows count
     */
    #[JsonProperty('total')]
    public ?int $total;

    /**
     * @var ?array<BorrowsUpdateParamsRecordsItem> $records
     */
    #[JsonProperty('records'), ArrayType([BorrowsUpdateParamsRecordsItem::class])]
    public ?array $records;

    /**
     * @param array{
     *   total?: ?int,
     *   records?: ?array<BorrowsUpdateParamsRecordsItem>,
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

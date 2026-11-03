<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class GetFundingHistoryResponse extends JsonSerializableType
{
    /**
     * @var ?array<GetFundingHistoryResponseRecordsItem> $records Array of funding history entries
     */
    #[JsonProperty('records'), ArrayType([GetFundingHistoryResponseRecordsItem::class])]
    public ?array $records;

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
     * @param array{
     *   records?: ?array<GetFundingHistoryResponseRecordsItem>,
     *   limit?: ?int,
     *   offset?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->records = $values['records'] ?? null;
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

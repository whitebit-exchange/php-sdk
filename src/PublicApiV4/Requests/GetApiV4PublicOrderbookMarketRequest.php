<?php

namespace Whitebit\PublicApiV4\Requests;

use Whitebit\Core\Json\JsonSerializableType;

class GetApiV4PublicOrderbookMarketRequest extends JsonSerializableType
{
    /**
     * @var ?int $limit Orders depth quantity: 0 - 100. Not defined or 0 will return 100 entries.
     */
    public ?int $limit;

    /**
     * @var ?int $level Aggregation level for price grouping. Level 0 applies no aggregation. Levels 1–5 provide increasing aggregation of the order book; values up to 10 are accepted. Out-of-range values are clamped to the 0–10 range rather than rejected.
     */
    public ?int $level;

    /**
     * @param array{
     *   limit?: ?int,
     *   level?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->limit = $values['limit'] ?? null;
        $this->level = $values['level'] ?? null;
    }
}

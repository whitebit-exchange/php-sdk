<?php

namespace Whitebit\CryptoLendingFixed\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Types\Investment;
use Whitebit\Core\Types\ArrayType;

class GetFixedInvestmentsHistoryResponse extends JsonSerializableType
{
    /**
     * @var ?int $offset
     */
    #[JsonProperty('offset')]
    public ?int $offset;

    /**
     * @var ?int $limit
     */
    #[JsonProperty('limit')]
    public ?int $limit;

    /**
     * @var ?array<Investment> $records
     */
    #[JsonProperty('records'), ArrayType([Investment::class])]
    public ?array $records;

    /**
     * @param array{
     *   offset?: ?int,
     *   limit?: ?int,
     *   records?: ?array<Investment>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->offset = $values['offset'] ?? null;
        $this->limit = $values['limit'] ?? null;
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

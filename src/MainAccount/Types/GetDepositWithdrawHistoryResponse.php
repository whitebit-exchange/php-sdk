<?php

namespace Whitebit\MainAccount\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Types\TransactionHistory;
use Whitebit\Core\Types\ArrayType;

class GetDepositWithdrawHistoryResponse extends JsonSerializableType
{
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
     * @var ?array<TransactionHistory> $records
     */
    #[JsonProperty('records'), ArrayType([TransactionHistory::class])]
    public ?array $records;

    /**
     * @var ?int $total Total number of transactions, use this for calculating 'limit' and 'offset'
     */
    #[JsonProperty('total')]
    public ?int $total;

    /**
     * @param array{
     *   limit?: ?int,
     *   offset?: ?int,
     *   records?: ?array<TransactionHistory>,
     *   total?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->limit = $values['limit'] ?? null;
        $this->offset = $values['offset'] ?? null;
        $this->records = $values['records'] ?? null;
        $this->total = $values['total'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

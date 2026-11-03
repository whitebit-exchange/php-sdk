<?php

namespace Whitebit\CryptoLendingFixed\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Types\InterestPayment;
use Whitebit\Core\Types\ArrayType;

class GetInterestPaymentHistoryResponse extends JsonSerializableType
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
     * @var ?array<InterestPayment> $records
     */
    #[JsonProperty('records'), ArrayType([InterestPayment::class])]
    public ?array $records;

    /**
     * @param array{
     *   offset?: ?int,
     *   limit?: ?int,
     *   records?: ?array<InterestPayment>,
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

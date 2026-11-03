<?php

namespace Whitebit\CryptoLendingFlex\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Types\FlexInvestmentHistory;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class GetFlexPaymentHistoryResponse extends JsonSerializableType
{
    /**
     * @var ?array<FlexInvestmentHistory> $data
     */
    #[JsonProperty('data'), ArrayType([FlexInvestmentHistory::class])]
    public ?array $data;

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
     * @param array{
     *   data?: ?array<FlexInvestmentHistory>,
     *   limit?: ?int,
     *   offset?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->data = $values['data'] ?? null;
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

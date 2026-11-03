<?php

namespace Whitebit\PublicApiV4\Requests;

use Whitebit\Core\Json\JsonSerializableType;

class GetApiV4PublicFundingHistoryMarketRequest extends JsonSerializableType
{
    /**
     * @var ?int $startDate Start timestamp in seconds
     */
    public ?int $startDate;

    /**
     * @var ?int $endDate End timestamp in seconds
     */
    public ?int $endDate;

    /**
     * @var ?int $limit Number of records to return. Default: 100, Maximum: 100
     */
    public ?int $limit;

    /**
     * @var ?int $offset Number of records to skip. Maximum: 1000000
     */
    public ?int $offset;

    /**
     * @param array{
     *   startDate?: ?int,
     *   endDate?: ?int,
     *   limit?: ?int,
     *   offset?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->startDate = $values['startDate'] ?? null;
        $this->endDate = $values['endDate'] ?? null;
        $this->limit = $values['limit'] ?? null;
        $this->offset = $values['offset'] ?? null;
    }
}

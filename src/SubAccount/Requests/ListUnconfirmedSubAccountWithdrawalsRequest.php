<?php

namespace Whitebit\SubAccount\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class ListUnconfirmedSubAccountWithdrawalsRequest extends JsonSerializableType
{
    /**
     * @var ?int $limit Number of records to return.
     */
    #[JsonProperty('limit')]
    public ?int $limit;

    /**
     * @var ?int $offset Number of records to skip.
     */
    #[JsonProperty('offset')]
    public ?int $offset;

    /**
     * @var ?string $subAccountId Filter by specific sub-account external ID. If omitted, returns withdrawals from all sub-accounts.
     */
    #[JsonProperty('subAccountId')]
    public ?string $subAccountId;

    /**
     * @param array{
     *   limit?: ?int,
     *   offset?: ?int,
     *   subAccountId?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->limit = $values['limit'] ?? null;
        $this->offset = $values['offset'] ?? null;
        $this->subAccountId = $values['subAccountId'] ?? null;
    }
}

<?php

namespace Whitebit\MiningPool\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetMiningWorkerNamesRequest extends JsonSerializableType
{
    /**
     * @var string $account Mining pool account name
     */
    #[JsonProperty('account')]
    public string $account;

    /**
     * @var ?int $offset Pagination offset
     */
    #[JsonProperty('offset')]
    public ?int $offset;

    /**
     * @var ?int $limit Pagination limit
     */
    #[JsonProperty('limit')]
    public ?int $limit;

    /**
     * @param array{
     *   account: string,
     *   offset?: ?int,
     *   limit?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->account = $values['account'];
        $this->offset = $values['offset'] ?? null;
        $this->limit = $values['limit'] ?? null;
    }
}

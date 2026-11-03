<?php

namespace Whitebit\MiningPool\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetMiningRewardsRequest extends JsonSerializableType
{
    /**
     * @var ?string $account Mining pool account
     */
    #[JsonProperty('account')]
    public ?string $account;

    /**
     * @var ?int $from Date timestamp starting from which rewards are received
     */
    #[JsonProperty('from')]
    public ?int $from;

    /**
     * @var ?int $to Date timestamp until which rewards are received
     */
    #[JsonProperty('to')]
    public ?int $to;

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
     *   account?: ?string,
     *   from?: ?int,
     *   to?: ?int,
     *   limit?: ?int,
     *   offset?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->account = $values['account'] ?? null;
        $this->from = $values['from'] ?? null;
        $this->to = $values['to'] ?? null;
        $this->limit = $values['limit'] ?? null;
        $this->offset = $values['offset'] ?? null;
    }
}

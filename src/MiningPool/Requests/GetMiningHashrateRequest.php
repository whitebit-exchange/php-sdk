<?php

namespace Whitebit\MiningPool\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\MiningPool\Types\GetMiningHashrateRequestInterval;

class GetMiningHashrateRequest extends JsonSerializableType
{
    /**
     * @var string $account Mining pool account
     */
    #[JsonProperty('account')]
    public string $account;

    /**
     * @var ?int $from Unix timestamp of starting point
     */
    #[JsonProperty('from')]
    public ?int $from;

    /**
     * @var ?int $to Unix timestamp of final point
     */
    #[JsonProperty('to')]
    public ?int $to;

    /**
     * @var ?value-of<GetMiningHashrateRequestInterval> $interval Timestamp interval
     */
    #[JsonProperty('interval')]
    public ?string $interval;

    /**
     * @param array{
     *   account: string,
     *   from?: ?int,
     *   to?: ?int,
     *   interval?: ?value-of<GetMiningHashrateRequestInterval>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->account = $values['account'];
        $this->from = $values['from'] ?? null;
        $this->to = $values['to'] ?? null;
        $this->interval = $values['interval'] ?? null;
    }
}

<?php

namespace Whitebit\MiningPool\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\MiningPool\Types\GetMiningWorkerHashrateRequestInterval;

class GetMiningWorkerHashrateRequest extends JsonSerializableType
{
    /**
     * @var string $account Mining pool account name
     */
    #[JsonProperty('account')]
    public string $account;

    /**
     * @var string $worker Worker name
     */
    #[JsonProperty('worker')]
    public string $worker;

    /**
     * @var ?value-of<GetMiningWorkerHashrateRequestInterval> $interval Time frame granularity
     */
    #[JsonProperty('interval')]
    public ?string $interval;

    /**
     * @var ?int $from Start timestamp in Unix seconds. Must be <= now
     */
    #[JsonProperty('from')]
    public ?int $from;

    /**
     * @var ?int $to End timestamp in Unix seconds. Must be <= now
     */
    #[JsonProperty('to')]
    public ?int $to;

    /**
     * @param array{
     *   account: string,
     *   worker: string,
     *   interval?: ?value-of<GetMiningWorkerHashrateRequestInterval>,
     *   from?: ?int,
     *   to?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->account = $values['account'];
        $this->worker = $values['worker'];
        $this->interval = $values['interval'] ?? null;
        $this->from = $values['from'] ?? null;
        $this->to = $values['to'] ?? null;
    }
}

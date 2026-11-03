<?php

namespace Whitebit\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Types\ConvertEstimateRequestDirection;

class ConvertEstimateRequest extends JsonSerializableType
{
    /**
     * @var string $from From currency. Example: BTC
     */
    #[JsonProperty('from')]
    public string $from;

    /**
     * @var string $to To currency. Example: USDT
     */
    #[JsonProperty('to')]
    public string $to;

    /**
     * @var value-of<ConvertEstimateRequestDirection> $direction Convert amount direction, defines in which currency corresponding "amount" field is populated. Use "to" in case amount is in "to" currency, use "from" if amount is in "from" currency
     */
    #[JsonProperty('direction')]
    public string $direction;

    /**
     * @var string $amount Amount to convert or receive. The value is silently truncated to 8 decimal places before evaluation; excess decimals do not raise an error.
     */
    #[JsonProperty('amount')]
    public string $amount;

    /**
     * @var ?int $nonce Nonce for request
     */
    #[JsonProperty('nonce')]
    public ?int $nonce;

    /**
     * @var ?string $request Request path
     */
    #[JsonProperty('request')]
    public ?string $request;

    /**
     * @param array{
     *   from: string,
     *   to: string,
     *   direction: value-of<ConvertEstimateRequestDirection>,
     *   amount: string,
     *   nonce?: ?int,
     *   request?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->from = $values['from'];
        $this->to = $values['to'];
        $this->direction = $values['direction'];
        $this->amount = $values['amount'];
        $this->nonce = $values['nonce'] ?? null;
        $this->request = $values['request'] ?? null;
    }
}

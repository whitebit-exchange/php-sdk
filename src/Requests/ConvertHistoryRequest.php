<?php

namespace Whitebit\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class ConvertHistoryRequest extends JsonSerializableType
{
    /**
     * @var ?string $fromTicker From currency. Example: BTC
     */
    #[JsonProperty('fromTicker')]
    public ?string $fromTicker;

    /**
     * @var ?string $toTicker To currency. Example: USDT
     */
    #[JsonProperty('toTicker')]
    public ?string $toTicker;

    /**
     * @var ?string $from From time filter (Unix seconds). Must be no more than 30 days before `to` and no older than 6 months. Example: 1699260637. Default: now()
     */
    #[JsonProperty('from')]
    public ?string $from;

    /**
     * @var ?string $to To time filter (Unix seconds). Must be no more than 30 days after `from`. Example: 1699260637. Default: now()
     */
    #[JsonProperty('to')]
    public ?string $to;

    /**
     * @var ?string $quoteId Quote Id. Example: 4050
     */
    #[JsonProperty('quoteId')]
    public ?string $quoteId;

    /**
     * @var ?int $limit How many records to receive. Allowed range: 1–100. Default: 100
     */
    #[JsonProperty('limit')]
    public ?int $limit;

    /**
     * @var ?int $offset Number of records to skip for pagination. Minimum: 0. Default: 0
     */
    #[JsonProperty('offset')]
    public ?int $offset;

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
     *   fromTicker?: ?string,
     *   toTicker?: ?string,
     *   from?: ?string,
     *   to?: ?string,
     *   quoteId?: ?string,
     *   limit?: ?int,
     *   offset?: ?int,
     *   nonce?: ?int,
     *   request?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->fromTicker = $values['fromTicker'] ?? null;
        $this->toTicker = $values['toTicker'] ?? null;
        $this->from = $values['from'] ?? null;
        $this->to = $values['to'] ?? null;
        $this->quoteId = $values['quoteId'] ?? null;
        $this->limit = $values['limit'] ?? null;
        $this->offset = $values['offset'] ?? null;
        $this->nonce = $values['nonce'] ?? null;
        $this->request = $values['request'] ?? null;
    }
}

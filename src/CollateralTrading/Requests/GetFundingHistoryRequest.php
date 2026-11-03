<?php

namespace Whitebit\CollateralTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetFundingHistoryRequest extends JsonSerializableType
{
    /**
     * Filter by specific market. For example: BTC_PERP
     *
     * If not specified, returns funding history for all markets.
     *
     * @var ?string $market
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?int $limit Number of records to return
     */
    #[JsonProperty('limit')]
    public ?int $limit;

    /**
     * @var ?int $offset Number of records to skip
     */
    #[JsonProperty('offset')]
    public ?int $offset;

    /**
     * @var ?string $request Request signature
     */
    #[JsonProperty('request')]
    public ?string $request;

    /**
     * @var ?int $nonce Unique request identifier
     */
    #[JsonProperty('nonce')]
    public ?int $nonce;

    /**
     * @param array{
     *   market?: ?string,
     *   limit?: ?int,
     *   offset?: ?int,
     *   request?: ?string,
     *   nonce?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->market = $values['market'] ?? null;
        $this->limit = $values['limit'] ?? null;
        $this->offset = $values['offset'] ?? null;
        $this->request = $values['request'] ?? null;
        $this->nonce = $values['nonce'] ?? null;
    }
}

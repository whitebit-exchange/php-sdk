<?php

namespace Whitebit\CollateralTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetConditionalOrdersRequest extends JsonSerializableType
{
    /**
     * Filter by specific market. Example: BTC_USDT
     *
     * If not specified, returns conditional orders for all markets.
     *
     * @var ?string $market
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?int $offset Number of records to skip for pagination.
     */
    #[JsonProperty('offset')]
    public ?int $offset;

    /**
     * @var ?int $limit Maximum number of records to return per page.
     */
    #[JsonProperty('limit')]
    public ?int $limit;

    /**
     * @var ?string $request
     */
    #[JsonProperty('request')]
    public ?string $request;

    /**
     * @var ?int $nonce
     */
    #[JsonProperty('nonce')]
    public ?int $nonce;

    /**
     * @param array{
     *   market?: ?string,
     *   offset?: ?int,
     *   limit?: ?int,
     *   request?: ?string,
     *   nonce?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->market = $values['market'] ?? null;
        $this->offset = $values['offset'] ?? null;
        $this->limit = $values['limit'] ?? null;
        $this->request = $values['request'] ?? null;
        $this->nonce = $values['nonce'] ?? null;
    }
}

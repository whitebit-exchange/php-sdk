<?php

namespace Whitebit\CryptoLendingFlex\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetFlexPlansRequest extends JsonSerializableType
{
    /**
     * @var ?int $limit Pagination limit.
     */
    #[JsonProperty('limit')]
    public ?int $limit;

    /**
     * @var ?int $offset Pagination offset.
     */
    #[JsonProperty('offset')]
    public ?int $offset;

    /**
     * @var ?string $ticker Filter by currency [ticker](/glossary#ticker). Example: USDT
     */
    #[JsonProperty('ticker')]
    public ?string $ticker;

    /**
     * @var string $request Request signature
     */
    #[JsonProperty('request')]
    public string $request;

    /**
     * @var int $nonce Unique request identifier
     */
    #[JsonProperty('nonce')]
    public int $nonce;

    /**
     * @param array{
     *   request: string,
     *   nonce: int,
     *   limit?: ?int,
     *   offset?: ?int,
     *   ticker?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->limit = $values['limit'] ?? null;
        $this->offset = $values['offset'] ?? null;
        $this->ticker = $values['ticker'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

<?php

namespace Whitebit\CryptoLendingFixed\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetFixedInvestmentsHistoryRequest extends JsonSerializableType
{
    /**
     * @var ?string $id Investment identifier
     */
    #[JsonProperty('id')]
    public ?string $id;

    /**
     * @var ?string $ticker [Invest plan](/glossary#crypto-lending) source currency's [ticker](/glossary#ticker)
     */
    #[JsonProperty('ticker')]
    public ?string $ticker;

    /**
     * @var ?int $status Investment status (1 - active, 2 - closed)
     */
    #[JsonProperty('status')]
    public ?int $status;

    /**
     * @var ?int $limit LIMIT is a special clause used to limit records a particular query can return.
     */
    #[JsonProperty('limit')]
    public ?int $limit;

    /**
     * @var ?int $offset Use the OFFSET clause to return entries starting from a particular line.
     */
    #[JsonProperty('offset')]
    public ?int $offset;

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
     *   id?: ?string,
     *   ticker?: ?string,
     *   status?: ?int,
     *   limit?: ?int,
     *   offset?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'] ?? null;
        $this->ticker = $values['ticker'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->limit = $values['limit'] ?? null;
        $this->offset = $values['offset'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

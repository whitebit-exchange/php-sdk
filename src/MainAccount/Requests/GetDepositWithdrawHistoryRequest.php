<?php

namespace Whitebit\MainAccount\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class GetDepositWithdrawHistoryRequest extends JsonSerializableType
{
    /**
     * @var ?int $transactionMethod Method. Example: **1** to display deposits / **2** to display withdraws. Do not send this parameter in order to receive both deposits and withdraws.
     */
    #[JsonProperty('transactionMethod')]
    public ?int $transactionMethod;

    /**
     * @var ?string $ticker Currency's [ticker](/glossary#ticker). Example: BTC
     */
    #[JsonProperty('ticker')]
    public ?string $ticker;

    /**
     * @var ?string $address Can be used for filtering transactions by specific address.
     */
    #[JsonProperty('address')]
    public ?string $address;

    /**
     * @var ?string $memo Can be used for filtering transactions by specific [memo](/glossary#memodestination-tag)
     */
    #[JsonProperty('memo')]
    public ?string $memo;

    /**
     * @var ?array<string> $addresses Can be used for filtering transactions by specific array of addresses.
     */
    #[JsonProperty('addresses'), ArrayType(['string'])]
    public ?array $addresses;

    /**
     * @var ?string $uniqueId Can be used for filtering transactions by specific unique id
     */
    #[JsonProperty('unique_id')]
    public ?string $uniqueId;

    /**
     * @var ?int $limit LIMIT is a special clause used to limit records a particular query can return. Default: 50, Min: 1, Max: 500
     */
    #[JsonProperty('limit')]
    public ?int $limit;

    /**
     * @var ?int $offset Use the OFFSET clause to return entries starting from a particular line.
     */
    #[JsonProperty('offset')]
    public ?int $offset;

    /**
     * Can be used for filtering transactions by status codes.
     *
     * ⚠️ Caution: Use this parameter with the appropriate `transactionMethod` and valid status codes for that method. See the endpoint description above for valid codes. Example: `"status": [3,7]`
     *
     * @var ?array<int> $status
     */
    #[JsonProperty('status'), ArrayType(['integer'])]
    public ?array $status;

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
     *   transactionMethod?: ?int,
     *   ticker?: ?string,
     *   address?: ?string,
     *   memo?: ?string,
     *   addresses?: ?array<string>,
     *   uniqueId?: ?string,
     *   limit?: ?int,
     *   offset?: ?int,
     *   status?: ?array<int>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->transactionMethod = $values['transactionMethod'] ?? null;
        $this->ticker = $values['ticker'] ?? null;
        $this->address = $values['address'] ?? null;
        $this->memo = $values['memo'] ?? null;
        $this->addresses = $values['addresses'] ?? null;
        $this->uniqueId = $values['uniqueId'] ?? null;
        $this->limit = $values['limit'] ?? null;
        $this->offset = $values['offset'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

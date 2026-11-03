<?php

namespace Whitebit\CryptoLendingFlex\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class GetFlexInvestmentHistoryRequest extends JsonSerializableType
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
     * @var ?string $plan Filter by plan ID (UUID).
     */
    #[JsonProperty('plan')]
    public ?string $plan;

    /**
     * @var ?string $investment Filter by investment ID.
     */
    #[JsonProperty('investment')]
    public ?string $investment;

    /**
     * @var ?string $transaction Filter by transaction ID.
     */
    #[JsonProperty('transaction')]
    public ?string $transaction;

    /**
     * @var ?int $dateFrom Filter from date (timestamp).
     */
    #[JsonProperty('dateFrom')]
    public ?int $dateFrom;

    /**
     * @var ?int $dateTo Filter to date (timestamp).
     */
    #[JsonProperty('dateTo')]
    public ?int $dateTo;

    /**
     * @var ?array<int> $actionTypes Array of operation type IDs. See table below.
     */
    #[JsonProperty('actionTypes'), ArrayType(['integer'])]
    public ?array $actionTypes;

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
     *   plan?: ?string,
     *   investment?: ?string,
     *   transaction?: ?string,
     *   dateFrom?: ?int,
     *   dateTo?: ?int,
     *   actionTypes?: ?array<int>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->limit = $values['limit'] ?? null;
        $this->offset = $values['offset'] ?? null;
        $this->plan = $values['plan'] ?? null;
        $this->investment = $values['investment'] ?? null;
        $this->transaction = $values['transaction'] ?? null;
        $this->dateFrom = $values['dateFrom'] ?? null;
        $this->dateTo = $values['dateTo'] ?? null;
        $this->actionTypes = $values['actionTypes'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

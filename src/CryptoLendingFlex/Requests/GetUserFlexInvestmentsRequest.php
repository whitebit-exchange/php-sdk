<?php

namespace Whitebit\CryptoLendingFlex\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetUserFlexInvestmentsRequest extends JsonSerializableType
{
    /**
     * @var ?int $limit Pagination limit. Default: 100.
     */
    #[JsonProperty('limit')]
    public ?int $limit;

    /**
     * @var ?int $offset Pagination offset. Default: 0.
     */
    #[JsonProperty('offset')]
    public ?int $offset;

    /**
     * @var ?string $ticker Filter by currency [ticker](/glossary#ticker). Example: USDT.
     */
    #[JsonProperty('ticker')]
    public ?string $ticker;

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
     * @var ?int $investmentStatus Filter by status (1=ACTIVE, 0=CLOSED).
     */
    #[JsonProperty('investmentStatus')]
    public ?int $investmentStatus;

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
     *   plan?: ?string,
     *   investment?: ?string,
     *   investmentStatus?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->limit = $values['limit'] ?? null;
        $this->offset = $values['offset'] ?? null;
        $this->ticker = $values['ticker'] ?? null;
        $this->plan = $values['plan'] ?? null;
        $this->investment = $values['investment'] ?? null;
        $this->investmentStatus = $values['investmentStatus'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

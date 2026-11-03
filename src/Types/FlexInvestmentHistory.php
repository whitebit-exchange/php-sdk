<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class FlexInvestmentHistory extends JsonSerializableType
{
    /**
     * @var ?int $createdAt Transaction creation timestamp
     */
    #[JsonProperty('createdAt')]
    public ?int $createdAt;

    /**
     * @var ?string $planId Flex plan identifier
     */
    #[JsonProperty('planId')]
    public ?string $planId;

    /**
     * @var ?string $investmentId Flex investment identifier
     */
    #[JsonProperty('investmentId')]
    public ?string $investmentId;

    /**
     * @var ?string $currency Transaction currency
     */
    #[JsonProperty('currency')]
    public ?string $currency;

    /**
     * @var ?string $amount Transaction amount
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?string $transactionId Transaction identifier
     */
    #[JsonProperty('transaction_id')]
    public ?string $transactionId;

    /**
     * @var ?int $actionType Action type: 1-INVEST, 2-REINVEST, 3-WITHDRAW_FROM_INVESTMENT, 4-DAILY_EARNING, 5-CLOSE_INVESTMENT, 6-OPEN_INVESTMENT
     */
    #[JsonProperty('actionType')]
    public ?int $actionType;

    /**
     * @param array{
     *   createdAt?: ?int,
     *   planId?: ?string,
     *   investmentId?: ?string,
     *   currency?: ?string,
     *   amount?: ?string,
     *   transactionId?: ?string,
     *   actionType?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->createdAt = $values['createdAt'] ?? null;
        $this->planId = $values['planId'] ?? null;
        $this->investmentId = $values['investmentId'] ?? null;
        $this->currency = $values['currency'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->transactionId = $values['transactionId'] ?? null;
        $this->actionType = $values['actionType'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

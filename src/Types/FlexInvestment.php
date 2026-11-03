<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class FlexInvestment extends JsonSerializableType
{
    /**
     * @var ?string $id Flex investment identifier
     */
    #[JsonProperty('id')]
    public ?string $id;

    /**
     * @var ?string $planId Flex plan identifier
     */
    #[JsonProperty('planId')]
    public ?string $planId;

    /**
     * @var ?string $currency Investment currency
     */
    #[JsonProperty('currency')]
    public ?string $currency;

    /**
     * @var ?string $invested Invested amount
     */
    #[JsonProperty('invested')]
    public ?string $invested;

    /**
     * @var ?bool $withAutoReinvest Auto-reinvestment enabled
     */
    #[JsonProperty('withAutoReinvest')]
    public ?bool $withAutoReinvest;

    /**
     * @var ?int $status Investment status (1=ACTIVE, 0=CLOSED)
     */
    #[JsonProperty('status')]
    public ?int $status;

    /**
     * @var ?int $createdAt Investment creation timestamp
     */
    #[JsonProperty('createdAt')]
    public ?int $createdAt;

    /**
     * @var ?int $updatedAt Investment last update timestamp
     */
    #[JsonProperty('updatedAt')]
    public ?int $updatedAt;

    /**
     * @param array{
     *   id?: ?string,
     *   planId?: ?string,
     *   currency?: ?string,
     *   invested?: ?string,
     *   withAutoReinvest?: ?bool,
     *   status?: ?int,
     *   createdAt?: ?int,
     *   updatedAt?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->id = $values['id'] ?? null;
        $this->planId = $values['planId'] ?? null;
        $this->currency = $values['currency'] ?? null;
        $this->invested = $values['invested'] ?? null;
        $this->withAutoReinvest = $values['withAutoReinvest'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->createdAt = $values['createdAt'] ?? null;
        $this->updatedAt = $values['updatedAt'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

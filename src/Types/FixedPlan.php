<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class FixedPlan extends JsonSerializableType
{
    /**
     * @var ?string $id Invest plan identifier
     */
    #[JsonProperty('id')]
    public ?string $id;

    /**
     * @var ?string $ticker Source currency ticker
     */
    #[JsonProperty('ticker')]
    public ?string $ticker;

    /**
     * @var ?int $status Status (1 - active, 2 - no coins left, 3 - inactive, 4 - pause)
     */
    #[JsonProperty('status')]
    public ?int $status;

    /**
     * @var ?string $percent Interest percent
     */
    #[JsonProperty('percent')]
    public ?string $percent;

    /**
     * @var ?int $duration Investment duration (in minutes)
     */
    #[JsonProperty('duration')]
    public ?int $duration;

    /**
     * @var ?string $interestTicker Target currency ticker
     */
    #[JsonProperty('interestTicker')]
    public ?string $interestTicker;

    /**
     * @var ?string $interestRatio Target currency to source currency ratio
     */
    #[JsonProperty('interestRatio')]
    public ?string $interestRatio;

    /**
     * @var ?string $minInvestment Minimum investment amount
     */
    #[JsonProperty('minInvestment')]
    public ?string $minInvestment;

    /**
     * @var ?string $maxInvestment Maximum investment amount
     */
    #[JsonProperty('maxInvestment')]
    public ?string $maxInvestment;

    /**
     * @var ?string $maxPossibleInvestment Maximum investment amount due to current invest plan state
     */
    #[JsonProperty('maxPossibleInvestment')]
    public ?string $maxPossibleInvestment;

    /**
     * @param array{
     *   id?: ?string,
     *   ticker?: ?string,
     *   status?: ?int,
     *   percent?: ?string,
     *   duration?: ?int,
     *   interestTicker?: ?string,
     *   interestRatio?: ?string,
     *   minInvestment?: ?string,
     *   maxInvestment?: ?string,
     *   maxPossibleInvestment?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->id = $values['id'] ?? null;
        $this->ticker = $values['ticker'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->percent = $values['percent'] ?? null;
        $this->duration = $values['duration'] ?? null;
        $this->interestTicker = $values['interestTicker'] ?? null;
        $this->interestRatio = $values['interestRatio'] ?? null;
        $this->minInvestment = $values['minInvestment'] ?? null;
        $this->maxInvestment = $values['maxInvestment'] ?? null;
        $this->maxPossibleInvestment = $values['maxPossibleInvestment'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

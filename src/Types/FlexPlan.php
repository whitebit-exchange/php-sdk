<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class FlexPlan extends JsonSerializableType
{
    /**
     * @var ?string $id Flex plan identifier
     */
    #[JsonProperty('id')]
    public ?string $id;

    /**
     * @var ?string $ticker Currency [ticker](/glossary#ticker)
     */
    #[JsonProperty('ticker')]
    public ?string $ticker;

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
     * @var ?string $maxRate Maximum interest rate
     */
    #[JsonProperty('maxRate')]
    public ?string $maxRate;

    /**
     * @param array{
     *   id?: ?string,
     *   ticker?: ?string,
     *   minInvestment?: ?string,
     *   maxInvestment?: ?string,
     *   maxRate?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->id = $values['id'] ?? null;
        $this->ticker = $values['ticker'] ?? null;
        $this->minInvestment = $values['minInvestment'] ?? null;
        $this->maxInvestment = $values['maxInvestment'] ?? null;
        $this->maxRate = $values['maxRate'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

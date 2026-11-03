<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Fee amounts and transfer limits for a crypto asset
 */
class FeeDetails extends JsonSerializableType
{
    /**
     * @var ?string $maxAmount Maximum transaction amount for the operation and network. May be absent independently from other limit fields; absence typically indicates no upper limit applies.
     */
    #[JsonProperty('max_amount')]
    public ?string $maxAmount;

    /**
     * @var ?string $minAmount Minimum transaction amount for the operation and network. May be absent independently from other limit fields.
     */
    #[JsonProperty('min_amount')]
    public ?string $minAmount;

    /**
     * @var ?string $fixed Fixed fee amount per transaction. `null` if no fixed fee applies.
     */
    #[JsonProperty('fixed')]
    public ?string $fixed;

    /**
     * @var ?FeeDetailsFlex $flex Percentage-based (flexible) fee. `null` if no flexible fee applies.
     */
    #[JsonProperty('flex')]
    public ?FeeDetailsFlex $flex;

    /**
     * @param array{
     *   maxAmount?: ?string,
     *   minAmount?: ?string,
     *   fixed?: ?string,
     *   flex?: ?FeeDetailsFlex,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->maxAmount = $values['maxAmount'] ?? null;
        $this->minAmount = $values['minAmount'] ?? null;
        $this->fixed = $values['fixed'] ?? null;
        $this->flex = $values['flex'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

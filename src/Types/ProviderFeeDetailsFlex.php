<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Percentage-based (flexible) fee. `null` if no flexible fee applies.
 */
class ProviderFeeDetailsFlex extends JsonSerializableType
{
    /**
     * @var ?string $percent Fee percentage (e.g., `"1.5"` means 1.5%)
     */
    #[JsonProperty('percent')]
    public ?string $percent;

    /**
     * @var ?string $minFee Minimum fee amount regardless of percentage calculation
     */
    #[JsonProperty('min_fee')]
    public ?string $minFee;

    /**
     * @var ?string $maxFee Maximum fee amount regardless of percentage calculation
     */
    #[JsonProperty('max_fee')]
    public ?string $maxFee;

    /**
     * @param array{
     *   percent?: ?string,
     *   minFee?: ?string,
     *   maxFee?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->percent = $values['percent'] ?? null;
        $this->minFee = $values['minFee'] ?? null;
        $this->maxFee = $values['maxFee'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

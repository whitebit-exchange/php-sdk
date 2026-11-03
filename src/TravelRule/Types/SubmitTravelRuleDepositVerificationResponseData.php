<?php

namespace Whitebit\TravelRule\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class SubmitTravelRuleDepositVerificationResponseData extends JsonSerializableType
{
    /**
     * @var ?string $uniqueId Transaction external ID
     */
    #[JsonProperty('uniqueId')]
    public ?string $uniqueId;

    /**
     * Verification status:
     * - `submitted` - Data submitted successfully, awaiting review
     * - `approved` - Immediately approved (rare)
     * - Other SumSub review statuses
     *
     * @var ?string $status
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @param array{
     *   uniqueId?: ?string,
     *   status?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->uniqueId = $values['uniqueId'] ?? null;
        $this->status = $values['status'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

<?php

namespace Whitebit\TravelRule\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class SubmitTravelRuleDepositVerificationResponse extends JsonSerializableType
{
    /**
     * @var ?SubmitTravelRuleDepositVerificationResponseData $data
     */
    #[JsonProperty('data')]
    public ?SubmitTravelRuleDepositVerificationResponseData $data;

    /**
     * @param array{
     *   data?: ?SubmitTravelRuleDepositVerificationResponseData,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->data = $values['data'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

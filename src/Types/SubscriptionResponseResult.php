<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class SubscriptionResponseResult extends JsonSerializableType
{
    /**
     * @var value-of<SubscriptionResponseResultStatus> $status Fixed value: `success`.
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * @param array{
     *   status: value-of<SubscriptionResponseResultStatus>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->status = $values['status'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

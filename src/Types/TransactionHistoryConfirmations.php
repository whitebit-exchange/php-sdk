<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Confirmation details for crypto transactions
 */
class TransactionHistoryConfirmations extends JsonSerializableType
{
    /**
     * @var ?int $actual Actual number of confirmations
     */
    #[JsonProperty('actual')]
    public ?int $actual;

    /**
     * @var ?int $required Required number of confirmations
     */
    #[JsonProperty('required')]
    public ?int $required;

    /**
     * @param array{
     *   actual?: ?int,
     *   required?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->actual = $values['actual'] ?? null;
        $this->required = $values['required'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

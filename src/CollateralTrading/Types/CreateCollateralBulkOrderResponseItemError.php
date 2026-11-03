<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

/**
 * Error details when order creation failed, null when successful
 */
class CreateCollateralBulkOrderResponseItemError extends JsonSerializableType
{
    /**
     * @var ?int $code Error code
     */
    #[JsonProperty('code')]
    public ?int $code;

    /**
     * @var ?string $message Error message
     */
    #[JsonProperty('message')]
    public ?string $message;

    /**
     * @var ?array<string, array<string>> $errors Detailed validation errors
     */
    #[JsonProperty('errors'), ArrayType(['string' => ['string']])]
    public ?array $errors;

    /**
     * @param array{
     *   code?: ?int,
     *   message?: ?string,
     *   errors?: ?array<string, array<string>>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->code = $values['code'] ?? null;
        $this->message = $values['message'] ?? null;
        $this->errors = $values['errors'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

/**
 * Generic wrapped error envelope (fallback). Market-data validation errors use the flat PublicValidationError shape (HTTP 422) instead, and infrastructure-level failures (maintenance, rate limit, internal error, unknown route) are non-JSON or flat. See the API description for the full set of public error shapes.
 */
class ErrorV4 extends JsonSerializableType
{
    /**
     * @var ?bool $success
     */
    #[JsonProperty('success')]
    public ?bool $success;

    /**
     * @var ?string $message Error message
     */
    #[JsonProperty('message')]
    public ?string $message;

    /**
     * @var ?array<string> $errors
     */
    #[JsonProperty('errors'), ArrayType(['string'])]
    public ?array $errors;

    /**
     * @param array{
     *   success?: ?bool,
     *   message?: ?string,
     *   errors?: ?array<string>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->success = $values['success'] ?? null;
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

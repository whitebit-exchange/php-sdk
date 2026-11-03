<?php

namespace Whitebit\Jwt\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class IssueJwtTokenResponseData extends JsonSerializableType
{
    /**
     * @var ?string $token JWT token
     */
    #[JsonProperty('token')]
    public ?string $token;

    /**
     * @var ?int $expiresAt Token expiration timestamp
     */
    #[JsonProperty('expires_at')]
    public ?int $expiresAt;

    /**
     * @param array{
     *   token?: ?string,
     *   expiresAt?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->token = $values['token'] ?? null;
        $this->expiresAt = $values['expiresAt'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

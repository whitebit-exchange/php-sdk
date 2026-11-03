<?php

namespace Whitebit\Jwt\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class IssueJwtTokenResponse extends JsonSerializableType
{
    /**
     * @var ?IssueJwtTokenResponseData $data
     */
    #[JsonProperty('data')]
    public ?IssueJwtTokenResponseData $data;

    /**
     * @param array{
     *   data?: ?IssueJwtTokenResponseData,
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

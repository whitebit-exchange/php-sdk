<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class AuthorizeResponseResult extends JsonSerializableType
{
    /**
     * @var value-of<AuthorizeResponseResultStatus> $status Fixed value: `success`.
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * @param array{
     *   status: value-of<AuthorizeResponseResultStatus>,
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

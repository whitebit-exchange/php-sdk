<?php

namespace Whitebit\SubAccountApiKeys\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class DeleteSubAccountApiKeyIpAddressResponse extends JsonSerializableType
{
    /**
     * @var ?array<string> $data
     */
    #[JsonProperty('data'), ArrayType(['string'])]
    public ?array $data;

    /**
     * @param array{
     *   data?: ?array<string>,
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

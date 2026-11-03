<?php

namespace Whitebit\PublicApiV4\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class GetApiV4PublicCollateralMarketsResponse extends JsonSerializableType
{
    /**
     * @var ?bool $success
     */
    #[JsonProperty('success')]
    public ?bool $success;

    /**
     * @var ?string $message
     */
    #[JsonProperty('message')]
    public ?string $message;

    /**
     * @var ?array<string> $result
     */
    #[JsonProperty('result'), ArrayType(['string'])]
    public ?array $result;

    /**
     * @param array{
     *   success?: ?bool,
     *   message?: ?string,
     *   result?: ?array<string>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->success = $values['success'] ?? null;
        $this->message = $values['message'] ?? null;
        $this->result = $values['result'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

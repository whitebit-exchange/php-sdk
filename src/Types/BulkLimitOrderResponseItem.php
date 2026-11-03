<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class BulkLimitOrderResponseItem extends JsonSerializableType
{
    /**
     * @var ?OrderResponse $result
     */
    #[JsonProperty('result')]
    public ?OrderResponse $result;

    /**
     * @var ?ErrorResponse $error
     */
    #[JsonProperty('error')]
    public ?ErrorResponse $error;

    /**
     * @param array{
     *   result?: ?OrderResponse,
     *   error?: ?ErrorResponse,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->result = $values['result'] ?? null;
        $this->error = $values['error'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

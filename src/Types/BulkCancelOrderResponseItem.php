<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class BulkCancelOrderResponseItem extends JsonSerializableType
{
    /**
     * @var ?BulkCancelOrderResult $result
     */
    #[JsonProperty('result')]
    public ?BulkCancelOrderResult $result;

    /**
     * @var ?ErrorResponse $error
     */
    #[JsonProperty('error')]
    public ?ErrorResponse $error;

    /**
     * @param array{
     *   result?: ?BulkCancelOrderResult,
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

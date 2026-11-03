<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class SubscriptionResponse extends JsonSerializableType
{
    /**
     * @var int $id Request identifier matching the request
     */
    #[JsonProperty('id')]
    public int $id;

    /**
     * @var SubscriptionResponseResult $result
     */
    #[JsonProperty('result')]
    public SubscriptionResponseResult $result;

    /**
     * @var mixed $error Error object (null on success)
     */
    #[JsonProperty('error')]
    public mixed $error;

    /**
     * @param array{
     *   id: int,
     *   result: SubscriptionResponseResult,
     *   error?: mixed,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'];
        $this->result = $values['result'];
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

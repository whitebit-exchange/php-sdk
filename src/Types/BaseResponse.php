<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class BaseResponse extends JsonSerializableType
{
    /**
     * @var int $id Request identifier matching the request
     */
    #[JsonProperty('id')]
    public int $id;

    /**
     * @var mixed $error
     */
    #[JsonProperty('error')]
    public mixed $error;

    /**
     * @param array{
     *   id: int,
     *   error?: mixed,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'];
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

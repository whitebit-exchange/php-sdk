<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Traits\BaseResponse;
use Whitebit\Core\Json\JsonProperty;

class TimeResponse extends JsonSerializableType
{
    use BaseResponse;

    /**
     * @var ?int $result Unix timestamp
     */
    #[JsonProperty('result')]
    public ?int $result;

    /**
     * @param array{
     *   id: int,
     *   error?: mixed,
     *   result?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'];
        $this->error = $values['error'] ?? null;
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

<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Traits\BaseResponse;
use Whitebit\Core\Json\JsonProperty;

class PingResponse extends JsonSerializableType
{
    use BaseResponse;

    /**
     * @var ?value-of<PingResponseResult> $result
     */
    #[JsonProperty('result')]
    public ?string $result;

    /**
     * @param array{
     *   id: int,
     *   error?: mixed,
     *   result?: ?value-of<PingResponseResult>,
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

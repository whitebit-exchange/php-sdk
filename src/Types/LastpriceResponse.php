<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class LastpriceResponse extends JsonSerializableType
{
    /**
     * @var int $id
     */
    #[JsonProperty('id')]
    public int $id;

    /**
     * @var string $result Last price
     */
    #[JsonProperty('result')]
    public string $result;

    /**
     * @var mixed $error
     */
    #[JsonProperty('error')]
    public mixed $error;

    /**
     * @param array{
     *   id: int,
     *   result: string,
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

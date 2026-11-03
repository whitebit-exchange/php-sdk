<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class MarketResponse extends JsonSerializableType
{
    /**
     * @var int $id
     */
    #[JsonProperty('id')]
    public int $id;

    /**
     * @var MarketStatistics $result
     */
    #[JsonProperty('result')]
    public MarketStatistics $result;

    /**
     * @var mixed $error
     */
    #[JsonProperty('error')]
    public mixed $error;

    /**
     * @param array{
     *   id: int,
     *   result: MarketStatistics,
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

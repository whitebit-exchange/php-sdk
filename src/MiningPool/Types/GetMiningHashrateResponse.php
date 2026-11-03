<?php

namespace Whitebit\MiningPool\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetMiningHashrateResponse extends JsonSerializableType
{
    /**
     * @var ?GetMiningHashrateResponseData $data
     */
    #[JsonProperty('data')]
    public ?GetMiningHashrateResponseData $data;

    /**
     * @param array{
     *   data?: ?GetMiningHashrateResponseData,
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

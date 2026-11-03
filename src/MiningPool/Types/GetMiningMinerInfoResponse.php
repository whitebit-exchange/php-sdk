<?php

namespace Whitebit\MiningPool\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetMiningMinerInfoResponse extends JsonSerializableType
{
    /**
     * @var ?GetMiningMinerInfoResponseData $data
     */
    #[JsonProperty('data')]
    public ?GetMiningMinerInfoResponseData $data;

    /**
     * @param array{
     *   data?: ?GetMiningMinerInfoResponseData,
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

<?php

namespace Whitebit\MiningPool\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetMiningWorkerHashrateResponse extends JsonSerializableType
{
    /**
     * @var ?GetMiningWorkerHashrateResponseData $data
     */
    #[JsonProperty('data')]
    public ?GetMiningWorkerHashrateResponseData $data;

    /**
     * @param array{
     *   data?: ?GetMiningWorkerHashrateResponseData,
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

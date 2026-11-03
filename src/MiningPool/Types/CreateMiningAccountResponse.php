<?php

namespace Whitebit\MiningPool\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CreateMiningAccountResponse extends JsonSerializableType
{
    /**
     * @var ?CreateMiningAccountResponseData $data
     */
    #[JsonProperty('data')]
    public ?CreateMiningAccountResponseData $data;

    /**
     * @param array{
     *   data?: ?CreateMiningAccountResponseData,
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

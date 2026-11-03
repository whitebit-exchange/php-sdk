<?php

namespace Whitebit\MiningPool\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CreateMiningWatcherLinkResponse extends JsonSerializableType
{
    /**
     * @var ?CreateMiningWatcherLinkResponseData $data
     */
    #[JsonProperty('data')]
    public ?CreateMiningWatcherLinkResponseData $data;

    /**
     * @param array{
     *   data?: ?CreateMiningWatcherLinkResponseData,
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

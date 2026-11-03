<?php

namespace Whitebit\PublicApiV4\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetApiV4PublicMiningPoolResponse extends JsonSerializableType
{
    /**
     * @var ?GetApiV4PublicMiningPoolResponseData $data
     */
    #[JsonProperty('data')]
    public ?GetApiV4PublicMiningPoolResponseData $data;

    /**
     * @param array{
     *   data?: ?GetApiV4PublicMiningPoolResponseData,
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

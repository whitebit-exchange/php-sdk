<?php

namespace Whitebit\MiningPool\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class GetMiningWorkerNamesResponseData extends JsonSerializableType
{
    /**
     * @var ?array<string> $workers
     */
    #[JsonProperty('workers'), ArrayType(['string'])]
    public ?array $workers;

    /**
     * @param array{
     *   workers?: ?array<string>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->workers = $values['workers'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

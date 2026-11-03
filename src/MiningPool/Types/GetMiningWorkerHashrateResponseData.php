<?php

namespace Whitebit\MiningPool\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class GetMiningWorkerHashrateResponseData extends JsonSerializableType
{
    /**
     * @var ?array<GetMiningWorkerHashrateResponseDataHashratesItem> $hashrates
     */
    #[JsonProperty('hashrates'), ArrayType([GetMiningWorkerHashrateResponseDataHashratesItem::class])]
    public ?array $hashrates;

    /**
     * @param array{
     *   hashrates?: ?array<GetMiningWorkerHashrateResponseDataHashratesItem>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->hashrates = $values['hashrates'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

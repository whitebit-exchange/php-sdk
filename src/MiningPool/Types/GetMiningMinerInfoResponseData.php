<?php

namespace Whitebit\MiningPool\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class GetMiningMinerInfoResponseData extends JsonSerializableType
{
    /**
     * @var ?string $fee Fee percentage
     */
    #[JsonProperty('fee')]
    public ?string $fee;

    /**
     * @var ?GetMiningMinerInfoResponseDataWorkers $workers Worker counts grouped by status
     */
    #[JsonProperty('workers')]
    public ?GetMiningMinerInfoResponseDataWorkers $workers;

    /**
     * @var ?array<GetMiningMinerInfoResponseDataStratumItem> $stratum
     */
    #[JsonProperty('stratum'), ArrayType([GetMiningMinerInfoResponseDataStratumItem::class])]
    public ?array $stratum;

    /**
     * @param array{
     *   fee?: ?string,
     *   workers?: ?GetMiningMinerInfoResponseDataWorkers,
     *   stratum?: ?array<GetMiningMinerInfoResponseDataStratumItem>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->fee = $values['fee'] ?? null;
        $this->workers = $values['workers'] ?? null;
        $this->stratum = $values['stratum'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

<?php

namespace Whitebit\PublicApiV4\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class GetApiV4PublicMiningPoolResponseData extends JsonSerializableType
{
    /**
     * @var ?array<string> $connectionLinks
     */
    #[JsonProperty('connection_links'), ArrayType(['string'])]
    public ?array $connectionLinks;

    /**
     * @var ?string $location
     */
    #[JsonProperty('location')]
    public ?string $location;

    /**
     * @var ?array<string> $assets
     */
    #[JsonProperty('assets'), ArrayType(['string'])]
    public ?array $assets;

    /**
     * @var ?array<string> $rewardSchemes
     */
    #[JsonProperty('reward_schemes'), ArrayType(['string'])]
    public ?array $rewardSchemes;

    /**
     * @var ?int $workers
     */
    #[JsonProperty('workers')]
    public ?int $workers;

    /**
     * @var ?string $currentHashRate
     */
    #[JsonProperty('current_hash_rate')]
    public ?string $currentHashRate;

    /**
     * @var ?array<GetApiV4PublicMiningPoolResponseDataLast7DaysHashRateItem> $last7DaysHashRate
     */
    #[JsonProperty('last7days_hash_rate'), ArrayType([GetApiV4PublicMiningPoolResponseDataLast7DaysHashRateItem::class])]
    public ?array $last7DaysHashRate;

    /**
     * @var ?array<GetApiV4PublicMiningPoolResponseDataBlocksItem> $blocks
     */
    #[JsonProperty('blocks'), ArrayType([GetApiV4PublicMiningPoolResponseDataBlocksItem::class])]
    public ?array $blocks;

    /**
     * @param array{
     *   connectionLinks?: ?array<string>,
     *   location?: ?string,
     *   assets?: ?array<string>,
     *   rewardSchemes?: ?array<string>,
     *   workers?: ?int,
     *   currentHashRate?: ?string,
     *   last7DaysHashRate?: ?array<GetApiV4PublicMiningPoolResponseDataLast7DaysHashRateItem>,
     *   blocks?: ?array<GetApiV4PublicMiningPoolResponseDataBlocksItem>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->connectionLinks = $values['connectionLinks'] ?? null;
        $this->location = $values['location'] ?? null;
        $this->assets = $values['assets'] ?? null;
        $this->rewardSchemes = $values['rewardSchemes'] ?? null;
        $this->workers = $values['workers'] ?? null;
        $this->currentHashRate = $values['currentHashRate'] ?? null;
        $this->last7DaysHashRate = $values['last7DaysHashRate'] ?? null;
        $this->blocks = $values['blocks'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

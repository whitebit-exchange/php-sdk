<?php

namespace Whitebit\MiningPool\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class GetMiningHashrateResponseData extends JsonSerializableType
{
    /**
     * @var ?string $account
     */
    #[JsonProperty('account')]
    public ?string $account;

    /**
     * @var ?array<GetMiningHashrateResponseDataHashrateItem> $hashrate
     */
    #[JsonProperty('hashrate'), ArrayType([GetMiningHashrateResponseDataHashrateItem::class])]
    public ?array $hashrate;

    /**
     * @param array{
     *   account?: ?string,
     *   hashrate?: ?array<GetMiningHashrateResponseDataHashrateItem>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->account = $values['account'] ?? null;
        $this->hashrate = $values['hashrate'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

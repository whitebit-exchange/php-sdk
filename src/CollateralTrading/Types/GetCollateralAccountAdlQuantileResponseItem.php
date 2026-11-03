<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetCollateralAccountAdlQuantileResponseItem extends JsonSerializableType
{
    /**
     * @var ?string $market Perpetual market name. Format: `BASE_PERP`.
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?int $long ADL quantile for the long side of the position. Values range from `0` to `4`: `0` indicates the lowest deleveraging priority (safest position in the ADL queue); `4` indicates the highest probability of being selected as the ADL counterparty. The value is `null` when the account has no exposure on the long side.
     */
    #[JsonProperty('long')]
    public ?int $long;

    /**
     * @var ?int $short ADL quantile for the short side of the position. Values range from `0` to `4`: `0` indicates the lowest deleveraging priority; `4` indicates the highest probability of being selected as the ADL counterparty. The value is `null` when the account has no exposure on the short side.
     */
    #[JsonProperty('short')]
    public ?int $short;

    /**
     * @param array{
     *   market?: ?string,
     *   long?: ?int,
     *   short?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->market = $values['market'] ?? null;
        $this->long = $values['long'] ?? null;
        $this->short = $values['short'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

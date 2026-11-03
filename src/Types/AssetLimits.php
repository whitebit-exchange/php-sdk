<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

/**
 * Currency limits by each network. May be absent from the response.
 */
class AssetLimits extends JsonSerializableType
{
    /**
     * @var ?array<string, AssetLimitsDepositValue> $deposit Deposits limits
     */
    #[JsonProperty('deposit'), ArrayType(['string' => AssetLimitsDepositValue::class])]
    public ?array $deposit;

    /**
     * @var ?array<string, AssetLimitsWithdrawValue> $withdraw Withdraws limits
     */
    #[JsonProperty('withdraw'), ArrayType(['string' => AssetLimitsWithdrawValue::class])]
    public ?array $withdraw;

    /**
     * @param array{
     *   deposit?: ?array<string, AssetLimitsDepositValue>,
     *   withdraw?: ?array<string, AssetLimitsWithdrawValue>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->deposit = $values['deposit'] ?? null;
        $this->withdraw = $values['withdraw'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

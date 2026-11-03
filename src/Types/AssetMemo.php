<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Indicates whether the asset requires a memo for deposits and withdrawals
 */
class AssetMemo extends JsonSerializableType
{
    /**
     * @var ?bool $deposit
     */
    #[JsonProperty('deposit')]
    public ?bool $deposit;

    /**
     * @var ?bool $withdraw
     */
    #[JsonProperty('withdraw')]
    public ?bool $withdraw;

    /**
     * @param array{
     *   deposit?: ?bool,
     *   withdraw?: ?bool,
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

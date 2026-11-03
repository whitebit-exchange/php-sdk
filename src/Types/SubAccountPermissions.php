<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Sub-account permissions
 */
class SubAccountPermissions extends JsonSerializableType
{
    /**
     * @var ?bool $spotEnabled Spot trading enabled
     */
    #[JsonProperty('spotEnabled')]
    public ?bool $spotEnabled;

    /**
     * @var ?bool $collateralEnabled Collateral trading enabled
     */
    #[JsonProperty('collateralEnabled')]
    public ?bool $collateralEnabled;

    /**
     * @param array{
     *   spotEnabled?: ?bool,
     *   collateralEnabled?: ?bool,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->spotEnabled = $values['spotEnabled'] ?? null;
        $this->collateralEnabled = $values['collateralEnabled'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

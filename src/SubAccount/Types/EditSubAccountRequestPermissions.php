<?php

namespace Whitebit\SubAccount\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class EditSubAccountRequestPermissions extends JsonSerializableType
{
    /**
     * @var bool $spotEnabled Enable transfers to trade balance
     */
    #[JsonProperty('spotEnabled')]
    public bool $spotEnabled;

    /**
     * @var bool $collateralEnabled Enable transfers to collateral balance
     */
    #[JsonProperty('collateralEnabled')]
    public bool $collateralEnabled;

    /**
     * @param array{
     *   spotEnabled: bool,
     *   collateralEnabled: bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->spotEnabled = $values['spotEnabled'];
        $this->collateralEnabled = $values['collateralEnabled'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

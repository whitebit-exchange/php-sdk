<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * VASP (Virtual Asset Service Provider) information. Required when `walletType` is `hosted`.
 * Provide either `vaspId` (if VASP is in the list from `/travel-rule/vasps`) or `vaspName` (if not in list).
 */
class TravelRuleVasp extends JsonSerializableType
{
    /**
     * @var ?string $vaspId VASP ID from `/travel-rule/vasps` endpoint. Use this if the VASP is in the list.
     */
    #[JsonProperty('vaspId')]
    public ?string $vaspId;

    /**
     * @var ?string $vaspName VASP name as fallback if not in the list.
     */
    #[JsonProperty('vaspName')]
    public ?string $vaspName;

    /**
     * @param array{
     *   vaspId?: ?string,
     *   vaspName?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->vaspId = $values['vaspId'] ?? null;
        $this->vaspName = $values['vaspName'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

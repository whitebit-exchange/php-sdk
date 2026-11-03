<?php

namespace Whitebit\Withdraw\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * VASP (Virtual Asset Service Provider) information. Required if `walletType` is `hosted`.
 *
 * Use `vaspId` if the destination VASP is in the list from [Get VASPs](/api-reference/travel-rule/get-vasps), otherwise use `vaspName`.
 */
class CreateWithdrawRequestTravelRuleVaspData extends JsonSerializableType
{
    /**
     * @var ?string $vaspId VASP ID from the [Get VASPs](/api-reference/travel-rule/get-vasps) endpoint. Use this if the VASP is in the list.
     */
    #[JsonProperty('vaspId')]
    public ?string $vaspId;

    /**
     * @var ?string $vaspName VASP name as a string. Use this if the VASP is not in the list.
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

<?php

namespace Whitebit\Withdraw\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Travel Rule information for regulatory compliance.
 *
 * ⚠️ Required if currency is crypto and the account is from [EEA](/glossary#european-economic-area-eea)
 *
 * See [Travel Rule Overview](/api-reference/travel-rule/overview) for complete documentation.
 *
 * **Legacy format:** The API still accepts the old flat format (`type`, `vasp`, `name`, `address` fields), but this format will not pass Travel Rule verification. To complete Travel Rule compliance, use the new structured format with `walletType`, `beneficiary`, and `vasp` objects.
 */
class CreateWithdrawRequestTravelRule extends JsonSerializableType
{
    /**
     * Destination wallet type:
     * - `hosted` - VASP-hosted wallet (exchange, custodian). Requires `vasp` object.
     * - `unhosted` - Self-custody wallet (hardware, software). No `vasp` required.
     *
     * @var ?value-of<CreateWithdrawRequestTravelRuleWalletType> $walletType
     */
    #[JsonProperty('walletType')]
    public ?string $walletType;

    /**
     * @var ?CreateWithdrawRequestTravelRuleBeneficiary $beneficiary Beneficiary information.
     */
    #[JsonProperty('beneficiary')]
    public ?CreateWithdrawRequestTravelRuleBeneficiary $beneficiary;

    /**
     * VASP (Virtual Asset Service Provider) information. Required if `walletType` is `hosted`.
     *
     * Use `vaspId` if the destination VASP is in the list from [Get VASPs](/api-reference/travel-rule/get-vasps), otherwise use `vaspName`.
     *
     * @var ?CreateWithdrawRequestTravelRuleVaspData $vaspData
     */
    #[JsonProperty('vaspData')]
    public ?CreateWithdrawRequestTravelRuleVaspData $vaspData;

    /**
     * @param array{
     *   walletType?: ?value-of<CreateWithdrawRequestTravelRuleWalletType>,
     *   beneficiary?: ?CreateWithdrawRequestTravelRuleBeneficiary,
     *   vaspData?: ?CreateWithdrawRequestTravelRuleVaspData,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->walletType = $values['walletType'] ?? null;
        $this->beneficiary = $values['beneficiary'] ?? null;
        $this->vaspData = $values['vaspData'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

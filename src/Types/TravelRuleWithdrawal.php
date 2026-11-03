<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Travel Rule data for withdrawals. Required when the Travel Rule API is enabled for the user's region and the withdrawal is Travel Rule-eligible.
 *
 * **Backward Compatibility**: When the Travel Rule API is disabled for the user's region, this new format is still accepted and automatically mapped to the legacy format.
 */
class TravelRuleWithdrawal extends JsonSerializableType
{
    /**
     * Wallet type:
     * - `hosted` - VASP-hosted wallet (exchange, custodian). Requires `vaspData` object.
     * - `unhosted` - Self-custody wallet (hardware wallet, software wallet).
     *
     * @var value-of<TravelRuleWithdrawalWalletType> $walletType
     */
    #[JsonProperty('walletType')]
    public string $walletType;

    /**
     * @var TravelRuleBeneficiary $beneficiary
     */
    #[JsonProperty('beneficiary')]
    public TravelRuleBeneficiary $beneficiary;

    /**
     * @var ?TravelRuleVasp $vaspData
     */
    #[JsonProperty('vaspData')]
    public ?TravelRuleVasp $vaspData;

    /**
     * @param array{
     *   walletType: value-of<TravelRuleWithdrawalWalletType>,
     *   beneficiary: TravelRuleBeneficiary,
     *   vaspData?: ?TravelRuleVasp,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->walletType = $values['walletType'];
        $this->beneficiary = $values['beneficiary'];
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

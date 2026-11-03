<?php

namespace Whitebit\TravelRule\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\TravelRule\Types\TravelRuleDepositVerificationRequestWalletType;
use Whitebit\Types\TravelRuleOriginator;
use Whitebit\Types\TravelRuleVasp;

class TravelRuleDepositVerificationRequest extends JsonSerializableType
{
    /**
     * @var string $uniqueId Transaction external ID (from deposit/withdraw history)
     */
    #[JsonProperty('uniqueId')]
    public string $uniqueId;

    /**
     * Wallet type:
     * - `hosted` - VASP-hosted wallet (exchange, custodian). Requires `vaspData` object.
     * - `unhosted` - Self-custody wallet (hardware wallet, software wallet).
     *
     * @var value-of<TravelRuleDepositVerificationRequestWalletType> $walletType
     */
    #[JsonProperty('walletType')]
    public string $walletType;

    /**
     * @var TravelRuleOriginator $originator
     */
    #[JsonProperty('originator')]
    public TravelRuleOriginator $originator;

    /**
     * @var ?TravelRuleVasp $vaspData
     */
    #[JsonProperty('vaspData')]
    public ?TravelRuleVasp $vaspData;

    /**
     * @var string $request Request signature
     */
    #[JsonProperty('request')]
    public string $request;

    /**
     * @var int $nonce Unique request identifier
     */
    #[JsonProperty('nonce')]
    public int $nonce;

    /**
     * @param array{
     *   uniqueId: string,
     *   walletType: value-of<TravelRuleDepositVerificationRequestWalletType>,
     *   originator: TravelRuleOriginator,
     *   request: string,
     *   nonce: int,
     *   vaspData?: ?TravelRuleVasp,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->uniqueId = $values['uniqueId'];
        $this->walletType = $values['walletType'];
        $this->originator = $values['originator'];
        $this->vaspData = $values['vaspData'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}

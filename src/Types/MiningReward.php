<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class MiningReward extends JsonSerializableType
{
    /**
     * @var ?string $miningAccountName Mining account name
     */
    #[JsonProperty('miningAccountName')]
    public ?string $miningAccountName;

    /**
     * @var ?value-of<MiningRewardPayoutDestination> $payoutDestination Payout destination
     */
    #[JsonProperty('payoutDestination')]
    public ?string $payoutDestination;

    /**
     * @var ?string $payoutTransactionHash Payout transaction hash. null in case payout destination is main_balance, blockchain transaction hash in case payout destination is external_address
     */
    #[JsonProperty('payoutTransactionHash')]
    public ?string $payoutTransactionHash;

    /**
     * @var ?string $payoutAddress Payout address. External wallet address in case payout destination is external_address, null in case payout destination is main_balance
     */
    #[JsonProperty('payoutAddress')]
    public ?string $payoutAddress;

    /**
     * @var ?int $payoutTime Timestamp when the external transaction is completed. null in case payout destination is main_balance
     */
    #[JsonProperty('payoutTime')]
    public ?int $payoutTime;

    /**
     * @var ?string $rewardCurrency Reward currency
     */
    #[JsonProperty('rewardCurrency')]
    public ?string $rewardCurrency;

    /**
     * @var ?string $totalReward Total reward amount
     */
    #[JsonProperty('totalReward')]
    public ?string $totalReward;

    /**
     * @var ?string $reward Reward amount (without fee)
     */
    #[JsonProperty('reward')]
    public ?string $reward;

    /**
     * @var ?string $fee Fee amount
     */
    #[JsonProperty('fee')]
    public ?string $fee;

    /**
     * @var ?string $fppsRate FPPS rate
     */
    #[JsonProperty('fppsRate')]
    public ?string $fppsRate;

    /**
     * @var ?string $hashRate Hash rate (H/s)
     */
    #[JsonProperty('hashRate')]
    public ?string $hashRate;

    /**
     * @var ?int $date Reward date timestamp
     */
    #[JsonProperty('date')]
    public ?int $date;

    /**
     * Current status of the mining reward. Possible values:
     *   - `pending` — the reward is not finalized yet. May mean either "waiting for block confirmations / batch accumulation" or "ready for payout, but the onchain transaction hasn't gone through". No user action needed — just wait.
     *   - `successful` — the reward is finalized. For `main_balance` payout, funds are credited to the main balance. For `external_address` payout, the onchain transaction is confirmed.
     *   - `canceled` — the reward was canceled.
     *
     * @var ?value-of<MiningRewardStatus> $status
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @param array{
     *   miningAccountName?: ?string,
     *   payoutDestination?: ?value-of<MiningRewardPayoutDestination>,
     *   payoutTransactionHash?: ?string,
     *   payoutAddress?: ?string,
     *   payoutTime?: ?int,
     *   rewardCurrency?: ?string,
     *   totalReward?: ?string,
     *   reward?: ?string,
     *   fee?: ?string,
     *   fppsRate?: ?string,
     *   hashRate?: ?string,
     *   date?: ?int,
     *   status?: ?value-of<MiningRewardStatus>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->miningAccountName = $values['miningAccountName'] ?? null;
        $this->payoutDestination = $values['payoutDestination'] ?? null;
        $this->payoutTransactionHash = $values['payoutTransactionHash'] ?? null;
        $this->payoutAddress = $values['payoutAddress'] ?? null;
        $this->payoutTime = $values['payoutTime'] ?? null;
        $this->rewardCurrency = $values['rewardCurrency'] ?? null;
        $this->totalReward = $values['totalReward'] ?? null;
        $this->reward = $values['reward'] ?? null;
        $this->fee = $values['fee'] ?? null;
        $this->fppsRate = $values['fppsRate'] ?? null;
        $this->hashRate = $values['hashRate'] ?? null;
        $this->date = $values['date'] ?? null;
        $this->status = $values['status'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

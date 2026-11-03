<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class MainAccountFeeInfo extends JsonSerializableType
{
    /**
     * @var ?string $ticker Currency [ticker](/glossary#ticker)
     */
    #[JsonProperty('ticker')]
    public ?string $ticker;

    /**
     * @var ?string $name Currency name
     */
    #[JsonProperty('name')]
    public ?string $name;

    /**
     * @var ?bool $canDeposit Deposit status (currency availability)
     */
    #[JsonProperty('can_deposit')]
    public ?bool $canDeposit;

    /**
     * @var ?bool $canWithdraw Withdrawal status (currency availability)
     */
    #[JsonProperty('can_withdraw')]
    public ?bool $canWithdraw;

    /**
     * @var ?MainAccountFeeInfoDeposit $deposit Deposit fees and limits
     */
    #[JsonProperty('deposit')]
    public ?MainAccountFeeInfoDeposit $deposit;

    /**
     * @var ?MainAccountFeeInfoWithdraw $withdraw Withdrawal fees and limits
     */
    #[JsonProperty('withdraw')]
    public ?MainAccountFeeInfoWithdraw $withdraw;

    /**
     * @param array{
     *   ticker?: ?string,
     *   name?: ?string,
     *   canDeposit?: ?bool,
     *   canWithdraw?: ?bool,
     *   deposit?: ?MainAccountFeeInfoDeposit,
     *   withdraw?: ?MainAccountFeeInfoWithdraw,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->ticker = $values['ticker'] ?? null;
        $this->name = $values['name'] ?? null;
        $this->canDeposit = $values['canDeposit'] ?? null;
        $this->canWithdraw = $values['canWithdraw'] ?? null;
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

<?php

namespace Whitebit\Transfer\Types;

enum TransferBetweenBalancesRequestMethod: string
{
    case Deposit = "deposit";
    case Withdraw = "withdraw";
    case CollateralDeposit = "collateral-deposit";
    case CollateralWithdraw = "collateral-withdraw";
}

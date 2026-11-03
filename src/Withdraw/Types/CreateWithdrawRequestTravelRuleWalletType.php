<?php

namespace Whitebit\Withdraw\Types;

enum CreateWithdrawRequestTravelRuleWalletType: string
{
    case Hosted = "hosted";
    case Unhosted = "unhosted";
}

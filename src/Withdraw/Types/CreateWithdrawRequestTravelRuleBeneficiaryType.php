<?php

namespace Whitebit\Withdraw\Types;

enum CreateWithdrawRequestTravelRuleBeneficiaryType: string
{
    case Individual = "individual";
    case Entity = "entity";
}

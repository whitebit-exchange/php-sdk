<?php

namespace Whitebit\TravelRule\Types;

enum TravelRuleDepositVerificationRequestWalletType: string
{
    case Hosted = "hosted";
    case Unhosted = "unhosted";
}

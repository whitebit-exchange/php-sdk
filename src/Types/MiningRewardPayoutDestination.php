<?php

namespace Whitebit\Types;

enum MiningRewardPayoutDestination: string
{
    case MainBalance = "main_balance";
    case ExternalAddress = "external_address";
}

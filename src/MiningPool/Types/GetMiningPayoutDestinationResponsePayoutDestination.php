<?php

namespace Whitebit\MiningPool\Types;

enum GetMiningPayoutDestinationResponsePayoutDestination: string
{
    case MainBalance = "main_balance";
    case ExternalAddress = "external_address";
}

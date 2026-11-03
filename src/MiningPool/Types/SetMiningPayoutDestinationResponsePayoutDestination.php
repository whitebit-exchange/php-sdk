<?php

namespace Whitebit\MiningPool\Types;

enum SetMiningPayoutDestinationResponsePayoutDestination: string
{
    case MainBalance = "main_balance";
    case ExternalAddress = "external_address";
}

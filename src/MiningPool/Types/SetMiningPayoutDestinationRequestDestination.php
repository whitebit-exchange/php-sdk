<?php

namespace Whitebit\MiningPool\Types;

enum SetMiningPayoutDestinationRequestDestination: string
{
    case MainBalance = "main_balance";
    case ExternalAddress = "external_address";
}

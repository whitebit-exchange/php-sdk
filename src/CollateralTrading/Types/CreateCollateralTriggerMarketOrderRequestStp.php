<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralTriggerMarketOrderRequestStp: string
{
    case No = "no";
    case Cb = "cb";
    case Cn = "cn";
    case Co = "co";
}

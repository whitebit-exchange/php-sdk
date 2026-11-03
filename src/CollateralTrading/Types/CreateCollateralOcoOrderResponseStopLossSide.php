<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralOcoOrderResponseStopLossSide: string
{
    case Buy = "buy";
    case Sell = "sell";
}

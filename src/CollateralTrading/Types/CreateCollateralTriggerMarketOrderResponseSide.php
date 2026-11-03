<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralTriggerMarketOrderResponseSide: string
{
    case Buy = "buy";
    case Sell = "sell";
}

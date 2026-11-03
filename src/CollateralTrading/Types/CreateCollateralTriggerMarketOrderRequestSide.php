<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralTriggerMarketOrderRequestSide: string
{
    case Buy = "buy";
    case Sell = "sell";
}

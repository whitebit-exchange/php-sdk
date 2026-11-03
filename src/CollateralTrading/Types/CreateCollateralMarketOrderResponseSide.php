<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralMarketOrderResponseSide: string
{
    case Buy = "buy";
    case Sell = "sell";
}

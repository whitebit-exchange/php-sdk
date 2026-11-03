<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralOcoOrderResponseTakeProfitSide: string
{
    case Buy = "buy";
    case Sell = "sell";
}

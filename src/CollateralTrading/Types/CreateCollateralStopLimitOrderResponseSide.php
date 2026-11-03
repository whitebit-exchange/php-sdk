<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralStopLimitOrderResponseSide: string
{
    case Buy = "buy";
    case Sell = "sell";
}

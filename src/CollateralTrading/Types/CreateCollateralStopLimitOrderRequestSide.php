<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralStopLimitOrderRequestSide: string
{
    case Buy = "buy";
    case Sell = "sell";
}

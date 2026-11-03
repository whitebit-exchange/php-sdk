<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralMarketOrderRequestSide: string
{
    case Buy = "buy";
    case Sell = "sell";
}

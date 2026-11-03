<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralOcoOrderRequestSide: string
{
    case Buy = "buy";
    case Sell = "sell";
}

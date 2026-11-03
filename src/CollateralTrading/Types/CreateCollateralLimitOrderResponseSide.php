<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralLimitOrderResponseSide: string
{
    case Buy = "buy";
    case Sell = "sell";
}

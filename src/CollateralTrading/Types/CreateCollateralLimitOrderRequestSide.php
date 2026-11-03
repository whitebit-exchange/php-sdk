<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralLimitOrderRequestSide: string
{
    case Buy = "buy";
    case Sell = "sell";
}

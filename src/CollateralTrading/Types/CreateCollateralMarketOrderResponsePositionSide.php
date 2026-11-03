<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralMarketOrderResponsePositionSide: string
{
    case Long = "LONG";
    case Short = "SHORT";
    case Both = "BOTH";
}

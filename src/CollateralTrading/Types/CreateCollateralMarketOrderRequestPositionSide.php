<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralMarketOrderRequestPositionSide: string
{
    case Long = "LONG";
    case Short = "SHORT";
    case Both = "BOTH";
}

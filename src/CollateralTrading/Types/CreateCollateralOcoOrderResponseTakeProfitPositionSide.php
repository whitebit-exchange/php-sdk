<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralOcoOrderResponseTakeProfitPositionSide: string
{
    case Long = "LONG";
    case Short = "SHORT";
    case Both = "BOTH";
}

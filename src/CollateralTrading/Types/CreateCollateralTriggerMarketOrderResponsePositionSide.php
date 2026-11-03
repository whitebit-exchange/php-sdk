<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralTriggerMarketOrderResponsePositionSide: string
{
    case Long = "LONG";
    case Short = "SHORT";
    case Both = "BOTH";
}

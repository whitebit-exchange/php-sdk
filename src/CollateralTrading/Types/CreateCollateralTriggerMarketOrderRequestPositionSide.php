<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralTriggerMarketOrderRequestPositionSide: string
{
    case Long = "LONG";
    case Short = "SHORT";
    case Both = "BOTH";
}

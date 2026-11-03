<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralStopLimitOrderRequestPositionSide: string
{
    case Long = "LONG";
    case Short = "SHORT";
    case Both = "BOTH";
}

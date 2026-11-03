<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralLimitOrderRequestPositionSide: string
{
    case Long = "LONG";
    case Short = "SHORT";
    case Both = "BOTH";
}

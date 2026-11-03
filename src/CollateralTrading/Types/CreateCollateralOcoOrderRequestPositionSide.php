<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralOcoOrderRequestPositionSide: string
{
    case Long = "LONG";
    case Short = "SHORT";
    case Both = "BOTH";
}

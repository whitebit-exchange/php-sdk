<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralLimitOrderResponsePositionSide: string
{
    case Long = "LONG";
    case Short = "SHORT";
    case Both = "BOTH";
}

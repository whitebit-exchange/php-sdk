<?php

namespace Whitebit\CollateralTrading\Types;

enum GetOpenPositionsResponseItemPositionSide: string
{
    case Long = "LONG";
    case Short = "SHORT";
    case Both = "BOTH";
}

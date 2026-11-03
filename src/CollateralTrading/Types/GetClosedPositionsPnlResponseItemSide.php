<?php

namespace Whitebit\CollateralTrading\Types;

enum GetClosedPositionsPnlResponseItemSide: string
{
    case Long = "LONG";
    case Short = "SHORT";
    case Both = "BOTH";
}

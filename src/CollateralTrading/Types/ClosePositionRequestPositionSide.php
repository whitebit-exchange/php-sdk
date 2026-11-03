<?php

namespace Whitebit\CollateralTrading\Types;

enum ClosePositionRequestPositionSide: string
{
    case Long = "LONG";
    case Short = "SHORT";
    case Both = "BOTH";
}

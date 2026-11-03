<?php

namespace Whitebit\SpotTrading\Types;

enum CancelAllOrdersRequestPositionSide: string
{
    case Both = "both";
    case Long = "long";
    case Short = "short";
}

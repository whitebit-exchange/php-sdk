<?php

namespace Whitebit\Types;

enum ActiveOrderStatus: string
{
    case New_ = "NEW";
    case Filled = "FILLED";
    case PartiallyFilled = "PARTIALLY_FILLED";
    case Cancelled = "CANCELLED";
}

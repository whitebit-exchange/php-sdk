<?php

namespace Whitebit\SpotTrading\Types;

enum GetOrderHistoryRequestStatus: string
{
    case All = "ALL";
    case Filled = "FILLED";
    case Canceled = "CANCELED";
    case PartiallyFilled = "PARTIALLY_FILLED";
}

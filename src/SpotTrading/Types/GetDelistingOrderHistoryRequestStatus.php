<?php

namespace Whitebit\SpotTrading\Types;

enum GetDelistingOrderHistoryRequestStatus: string
{
    case Filled = "filled";
    case Delisting = "delisting";
}

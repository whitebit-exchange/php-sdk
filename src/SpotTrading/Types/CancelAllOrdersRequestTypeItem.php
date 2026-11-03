<?php

namespace Whitebit\SpotTrading\Types;

enum CancelAllOrdersRequestTypeItem: string
{
    case Spot = "spot";
    case Margin = "margin";
    case Futures = "futures";
}

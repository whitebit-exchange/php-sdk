<?php

namespace Whitebit\SpotTrading\Types;

enum StopMarketOrderRequestSide: string
{
    case Buy = "buy";
    case Sell = "sell";
}

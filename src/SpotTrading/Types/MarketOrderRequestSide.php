<?php

namespace Whitebit\SpotTrading\Types;

enum MarketOrderRequestSide: string
{
    case Buy = "buy";
    case Sell = "sell";
}

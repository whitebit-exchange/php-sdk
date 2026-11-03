<?php

namespace Whitebit\SpotTrading\Types;

enum StockMarketOrderRequestSide: string
{
    case Buy = "buy";
    case Sell = "sell";
}

<?php

namespace Whitebit\SpotTrading\Types;

enum GetOrderHistoryResponseValueItemSide: string
{
    case Buy = "buy";
    case Sell = "sell";
}

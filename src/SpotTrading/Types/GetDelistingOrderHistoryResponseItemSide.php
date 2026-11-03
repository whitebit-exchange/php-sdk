<?php

namespace Whitebit\SpotTrading\Types;

enum GetDelistingOrderHistoryResponseItemSide: string
{
    case Buy = "buy";
    case Sell = "sell";
}

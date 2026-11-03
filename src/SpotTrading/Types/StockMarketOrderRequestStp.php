<?php

namespace Whitebit\SpotTrading\Types;

enum StockMarketOrderRequestStp: string
{
    case No = "no";
    case Cb = "cb";
    case Cn = "cn";
    case Co = "co";
}

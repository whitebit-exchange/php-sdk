<?php

namespace Whitebit\SpotTrading\Types;

enum StopLimitOrderRequestSide: string
{
    case Buy = "buy";
    case Sell = "sell";
}

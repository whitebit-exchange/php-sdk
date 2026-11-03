<?php

namespace Whitebit\SpotTrading\Types;

enum LimitOrderRequestSide: string
{
    case Buy = "buy";
    case Sell = "sell";
}

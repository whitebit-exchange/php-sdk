<?php

namespace Whitebit\SpotTrading\Types;

enum MarketOrderRequestStp: string
{
    case No = "no";
    case Cb = "cb";
    case Cn = "cn";
    case Co = "co";
}

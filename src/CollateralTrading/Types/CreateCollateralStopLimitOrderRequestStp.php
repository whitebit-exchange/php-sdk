<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralStopLimitOrderRequestStp: string
{
    case No = "no";
    case Cb = "cb";
    case Cn = "cn";
    case Co = "co";
}

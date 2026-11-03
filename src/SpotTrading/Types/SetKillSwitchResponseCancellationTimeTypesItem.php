<?php

namespace Whitebit\SpotTrading\Types;

enum SetKillSwitchResponseCancellationTimeTypesItem: string
{
    case Spot = "spot";
    case Margin = "margin";
    case Futures = "futures";
}

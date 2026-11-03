<?php

namespace Whitebit\SpotTrading\Types;

enum GetKillSwitchStatusResponseItemTypesItem: string
{
    case Spot = "spot";
    case Margin = "margin";
    case Futures = "futures";
}

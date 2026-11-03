<?php

namespace Whitebit\SpotTrading\Types;

enum SetKillSwitchRequestTypesItem: string
{
    case Spot = "spot";
    case Margin = "margin";
    case Futures = "futures";
}

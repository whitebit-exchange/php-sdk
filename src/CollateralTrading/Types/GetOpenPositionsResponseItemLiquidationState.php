<?php

namespace Whitebit\CollateralTrading\Types;

enum GetOpenPositionsResponseItemLiquidationState: string
{
    case MarginCall = "margin_call";
    case Liquidation = "liquidation";
}

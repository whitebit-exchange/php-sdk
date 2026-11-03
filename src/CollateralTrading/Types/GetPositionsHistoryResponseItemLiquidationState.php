<?php

namespace Whitebit\CollateralTrading\Types;

enum GetPositionsHistoryResponseItemLiquidationState: string
{
    case MarginCall = "margin_call";
    case Liquidation = "liquidation";
}

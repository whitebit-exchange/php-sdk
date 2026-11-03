<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralBulkOrderResponseItemResultSide: string
{
    case Buy = "buy";
    case Sell = "sell";
}

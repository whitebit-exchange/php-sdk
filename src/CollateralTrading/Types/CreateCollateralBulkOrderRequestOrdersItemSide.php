<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralBulkOrderRequestOrdersItemSide: string
{
    case Buy = "buy";
    case Sell = "sell";
}

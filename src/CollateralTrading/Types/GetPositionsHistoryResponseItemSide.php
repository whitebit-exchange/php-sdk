<?php

namespace Whitebit\CollateralTrading\Types;

enum GetPositionsHistoryResponseItemSide: string
{
    case Long = "LONG";
    case Short = "SHORT";
    case Both = "BOTH";
}

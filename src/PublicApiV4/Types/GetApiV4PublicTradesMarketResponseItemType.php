<?php

namespace Whitebit\PublicApiV4\Types;

enum GetApiV4PublicTradesMarketResponseItemType: string
{
    case Buy = "buy";
    case Sell = "sell";
}

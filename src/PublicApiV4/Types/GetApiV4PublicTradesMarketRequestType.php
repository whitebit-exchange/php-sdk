<?php

namespace Whitebit\PublicApiV4\Types;

enum GetApiV4PublicTradesMarketRequestType: string
{
    case Buy = "buy";
    case Sell = "sell";
}

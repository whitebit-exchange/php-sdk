<?php

namespace Whitebit\PublicApiV4\Types;

enum GetApiV4PublicMarketsResponseItemType: string
{
    case Spot = "spot";
    case Futures = "futures";
    case TradfiFutures = "tradfiFutures";
}

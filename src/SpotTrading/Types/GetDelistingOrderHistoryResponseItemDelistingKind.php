<?php

namespace Whitebit\SpotTrading\Types;

enum GetDelistingOrderHistoryResponseItemDelistingKind: string
{
    case Reverse = "reverse";
    case Canceled = "canceled";
}

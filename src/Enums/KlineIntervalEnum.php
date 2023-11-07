<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Enums;

enum KlineIntervalEnum: string
{
    case ONE_MINUTE = '1m';
    case THREE_MINUTES = '3m';
    case FIVE_MINUTES = '5m';
    case FIFTEEN_MINUTES = '15m';
    case THIRTY_MINUTES = '30m';
    case ONE_HOUR = '1h';
    case TWO_HOURS = '2h';
    case FOUR_HOURS = '4h';
    case SIX_HOURS = '6h';
    case EIGHT_HOURS = '8h';
    case TWELVE_HOURS = '12h';
    case ONE_DAY = '1d';
    case THREE_DAYS = '3d';
    case ONE_WEEK = '1w';
    case ONE_MONTH = '1M';
}

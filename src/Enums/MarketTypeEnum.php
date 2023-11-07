<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Enums;

enum MarketTypeEnum: string
{
    case SPOT = 'spot';
    case FUTURES = 'futures';
}

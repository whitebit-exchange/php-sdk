<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Enums;

enum TransferDirectionEnum: string
{
    case MAIN = 'main';
    case SPOT = 'spot';
    case COLLATERAL = 'collateral';
}

<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Enums;

enum TransactionMethodEnum: int
{
    case DEPOSITS = 1;
    case WITHDRAWS = 2;
}

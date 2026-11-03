<?php

namespace Whitebit\CollateralTrading\Types;

enum CreateCollateralOcoOrderResponseStopLossActivationCondition: string
{
    case Gte = "gte";
    case Lte = "lte";
}

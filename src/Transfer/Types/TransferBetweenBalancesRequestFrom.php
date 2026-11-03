<?php

namespace Whitebit\Transfer\Types;

enum TransferBetweenBalancesRequestFrom: string
{
    case Main = "main";
    case Spot = "spot";
    case Collateral = "collateral";
}

<?php

namespace Whitebit\Transfer\Types;

enum TransferBetweenBalancesRequestTo: string
{
    case Main = "main";
    case Spot = "spot";
    case Collateral = "collateral";
}

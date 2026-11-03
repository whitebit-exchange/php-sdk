<?php

namespace Whitebit\MiningPool\Types;

enum GetMiningHashrateRequestInterval: string
{
    case FiveM = "5m";
    case OneH = "1h";
    case TwentyFourH = "24h";
}

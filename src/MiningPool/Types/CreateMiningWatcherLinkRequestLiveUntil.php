<?php

namespace Whitebit\MiningPool\Types;

enum CreateMiningWatcherLinkRequestLiveUntil: string
{
    case OneH = "1h";
    case TwentyFourH = "24h";
    case SevenD = "7d";
    case Always = "always";
}

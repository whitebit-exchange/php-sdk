<?php

namespace Whitebit\MiningPool\Types;

enum CreateMiningWatcherLinkRequestPermissionsItem: string
{
    case Dashboard = "dashboard";
    case Rewards = "rewards";
    case Workers = "workers";
}

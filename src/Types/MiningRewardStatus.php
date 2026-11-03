<?php

namespace Whitebit\Types;

enum MiningRewardStatus: string
{
    case Pending = "pending";
    case Successful = "successful";
    case Canceled = "canceled";
}

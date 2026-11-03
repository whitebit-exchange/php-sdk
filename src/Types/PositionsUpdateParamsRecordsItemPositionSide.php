<?php

namespace Whitebit\Types;

enum PositionsUpdateParamsRecordsItemPositionSide: string
{
    case Long = "LONG";
    case Short = "SHORT";
    case Both = "BOTH";
}

<?php

namespace Whitebit\Types;

enum ConditionalOrderLegPositionSide: string
{
    case Long = "LONG";
    case Short = "SHORT";
    case Both = "BOTH";
}

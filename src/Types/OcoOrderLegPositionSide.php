<?php

namespace Whitebit\Types;

enum OcoOrderLegPositionSide: string
{
    case Long = "LONG";
    case Short = "SHORT";
    case Both = "BOTH";
}

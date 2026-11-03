<?php

namespace Whitebit\Types;

enum ExecutedOrderObjectPositionSide: string
{
    case Long = "LONG";
    case Short = "SHORT";
    case Both = "BOTH";
}

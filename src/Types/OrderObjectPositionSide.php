<?php

namespace Whitebit\Types;

enum OrderObjectPositionSide: string
{
    case Long = "LONG";
    case Short = "SHORT";
    case Both = "BOTH";
}

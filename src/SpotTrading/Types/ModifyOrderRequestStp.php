<?php

namespace Whitebit\SpotTrading\Types;

enum ModifyOrderRequestStp: string
{
    case No = "no";
    case Cb = "cb";
    case Cn = "cn";
    case Co = "co";
}

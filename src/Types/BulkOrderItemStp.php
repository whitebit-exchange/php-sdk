<?php

namespace Whitebit\Types;

enum BulkOrderItemStp: string
{
    case No = "no";
    case Cb = "cb";
    case Cn = "cn";
    case Co = "co";
}

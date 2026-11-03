<?php

namespace Whitebit\Types;

enum OrderResponseActivationCondition: string
{
    case Lte = "lte";
    case Gte = "gte";
}

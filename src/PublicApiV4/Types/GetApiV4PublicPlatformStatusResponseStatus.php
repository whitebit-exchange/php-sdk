<?php

namespace Whitebit\PublicApiV4\Types;

enum GetApiV4PublicPlatformStatusResponseStatus: string
{
    case SystemOperational = "system operational";
    case SystemMaintenance = "system maintenance";
}

<?php

namespace Whitebit\SubAccount\Types;

enum GetSubAccountTransferHistoryRequestDirection: string
{
    case MainToSub = "main_to_sub";
    case SubToMain = "sub_to_main";
}

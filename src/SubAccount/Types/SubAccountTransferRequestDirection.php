<?php

namespace Whitebit\SubAccount\Types;

enum SubAccountTransferRequestDirection: string
{
    case MainToSub = "main_to_sub";
    case SubToMain = "sub_to_main";
}

<?php

namespace Whitebit\Deposit\Types;

enum CreateNewAddressRequestType: string
{
    case P2ShSegwit = "p2sh-segwit";
    case Bech32 = "bech32";
}

<?php

namespace App\Core\Extensions\V2ray\Models;

enum Protocol
{
    case VMESS;
    case VLESS;
    case SHADOWSOCKS;
    case TROJAN;
}

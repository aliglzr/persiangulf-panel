<?php

namespace App\Core\Extensions\V2ray\Models;

class ClientStats {
    public int $up;
    public int $down;
    public int $total;
    public string $email;
    public bool $enable;
    public int $inboundId;
    public int $expiryTime;
}
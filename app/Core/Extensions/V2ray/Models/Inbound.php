<?php

namespace App\Core\Extensions\V2ray\Models;

use Ergebnis\Json\Printer\Printer;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class Inbound
{
    public ?int $id;
    public int $up;
    public int $down;
    public int $total;
    public string $remark;
    public bool $enable;
    public ?bool $tls;
    public int $expiryTime;
    public ?string $listen;
    public ?string $transmission;
    public int $port;
    public Protocol $protocol;
    public object|array|null $settings;
    public object|array|null $streamSettings;
    public string $tag;
    public object|array|null $sniffing;
    public array $clientStats;


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'up' => $this->up,
            'down' => $this->down,
            'total' => $this->total,
            'remark' => $this->remark,
            'enable' => $this->enable,
            'expiryTime' => $this->expiryTime,
            'listen' => $this->listen,
            'port' => $this->port,
            'protocol' => strtolower($this->protocol->name),
            'settings' => str_replace("\r", '', (new Printer())->print(json_encode($this->settings, JSON_UNESCAPED_SLASHES), '  ')),
            'streamSettings' => str_replace("\r", '', (new Printer())->print(json_encode($this->streamSettings, JSON_UNESCAPED_SLASHES), '  ')),
            'tag' => $this->tag,
            'sniffing' => str_replace("\r", '', (new Printer())->print(json_encode($this->sniffing, JSON_UNESCAPED_SLASHES), '  ')),
            'clientStats' => $this->clientStats
        ];
    }



}

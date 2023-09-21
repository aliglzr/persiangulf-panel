<?php

namespace App\Http\Livewire\Dashboard\Manager\Index;

use Livewire\Component;

class Index extends Component
{
    public $code;
    public function getListeners(): array
    {
        return [
            "echo:LoginWithTelegram.".$this->code.",TelegramLoginCode" => 'telegramLoginCode',
            'refresh' => '$refresh'
        ];
    }
    public function mount()
    {
    }

    public function udp() {
        $server_ip   = '127.0.0.1';
        $server_port = 8080;
        $beat_period = 5;
        $message     = microtime(true);
        if ($socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)) {
                socket_sendto($socket, $message, strlen($message), 0, $server_ip, $server_port);
        } else {
            echo ("can't create socketn");
        }
    }


    public function render()
    {
        return view('livewire.dashboard.manager.index.index');
    }

}

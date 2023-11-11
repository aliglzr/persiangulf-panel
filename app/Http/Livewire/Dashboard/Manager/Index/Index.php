<?php

namespace App\Http\Livewire\Dashboard\Manager\Index;

use Livewire\Component;

class Index extends Component
{
    public $code;
    public $lr;
    public $ud;
    public $f;
    public $b;
    private $bldc1;
    private $bldc2;
    private $bldc3;
    private $bldc4;
    public float $micro = 0;
    public function getListeners(): array
    {
        return [
            "echo:LoginWithTelegram.".$this->code.",TelegramLoginCode" => 'telegramLoginCode',
            'refresh' => '$refresh'
        ];
    }
    public function mount()
    {
        $this->micro = 0;
    }

    public function command($lr, $ud,$f,$b, $gear, $micro) {
        if($this->micro == 0) {
            $this->micro = $micro;
        }
        if($micro - $this->micro > 100) {
            $this->micro = $micro;
        } else {
            return;
        }

        // LeftRight $lr
        // UpDown $ud
        // Forward $f
        // Backward $b
        if(true) {
            $server_ip   = '127.0.0.1';
            $server_port = 8080;
            $beat_period = 5;
            $maximum = 0;
            if($gear == 1) {
                $maximum = 24;
            } else if($gear == 2) {
                $maximum = 96;
            } else if($gear == 3) {
                $maximum = 168;
            } else if($gear == 4) {
                $maximum = 240;
            }
            $bldc2 = 0;
            $bldc4 = 0;
            $bldc1 = $maximum * $b;
            $bldc3 = $maximum * $b;
            $bnegative = 1;
            if($b < 0.001) {
                $bldc1 = $maximum * $f * -1;
                $bldc3 = $maximum * $f * -1;
                $bnegative = -1;
            }

            $angleForce = 0.3 * $bldc1;
            if($lr > 0) {
                $bldc1 += $angleForce * $lr * $bnegative;
                $bldc3 -= $angleForce * $lr * $bnegative;
            } else if($lr < 0) {
                $bldc1 += $angleForce * $lr * $bnegative;
                $bldc3 -= $angleForce * $lr * $bnegative;
            }

            $bldc2 = $maximum * -1 * $ud;
            $bldc4 = $maximum * -1 * $ud;
//            dd($bldc1, $bldc3, $bldc2, $bldc4);
//            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => "bldc1:".$bldc1]);

            $message     = '{"rid":'.rand(1000,9999).',"bldc1":'.$bldc1.',"bldc2":'.$bldc2.','.'"bldc3":'.$bldc3.','.'"bldc4":'.$bldc4.'}';
            if ($socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)) {
                socket_sendto($socket, $message, strlen($message), 0, $server_ip, $server_port);
            } else {
                echo ("can't create socketn");
            }
        }

    }

    public function udp() {
    }


    public function render()
    {
        return view('livewire.dashboard.manager.index.index');
    }

}

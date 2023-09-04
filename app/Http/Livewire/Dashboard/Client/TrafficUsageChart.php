<?php

namespace App\Http\Livewire\Dashboard\Client;

use App\Models\Server;
use App\Models\User;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Livewire\Component;

class TrafficUsageChart extends Component
{
    public ?DateTime $lastTime = null;
    public User $user;
    public function mount(User $user){
        $this->user = $user;
    }

    public function getTrafficUsageChartData(){
        $traffics = $this->user->trafficUsages();
        $this->dispatchBrowserEvent('traffic-data',['chartData' => $traffics->where('created_at' ,'>', now()->addMonths(-1))->pluck('net','created_at')->toArray()]);
    }

    public function render()
    {
        return view('livewire.dashboard.client.traffic-usage-chart');
    }
}

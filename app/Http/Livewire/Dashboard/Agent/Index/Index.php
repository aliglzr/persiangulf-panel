<?php

namespace App\Http\Livewire\Dashboard\Agent\Index;

use App\Core\Extensions\Verta\Verta;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Index extends Component
{
    public function mount(){

//        $begin = auth()->user()->created_at;
//        $end = now();
//
//        $interval = new DateInterval('P1D');
//        $daterange = new DatePeriod($begin, $interval ,$end);
//
//        $dates = [];
//
//        foreach($daterange as $date){
//            $dates[] = $date->format("Y-m-d");
//        }
        /** @var Collection $result */
        $result = auth()->user()->introduced()->role('client')->get()->groupBy('created_at');
        $test = [];
        foreach ($result as $key=>$item){
            $test[Verta::createFromFormat('Y-m-d H:i:s',$key)->format('Y-m-d')] = $item->count();
        }
    }
    public function getClientsByRange(){

    }

    public function render()
    {
        return view('livewire.dashboard.agent.index.index');
    }
}

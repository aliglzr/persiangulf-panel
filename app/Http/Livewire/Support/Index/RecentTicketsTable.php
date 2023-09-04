<?php

namespace App\Http\Livewire\Support\Index;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class RecentTicketsTable extends Component
{
    protected $listeners = ['refreshRecentTicketTable'];
    public Collection $tickets;


    public function refreshRecentTicketTable(){
        $this->tickets = auth()->user()->tickets()->latest()->take(5)->get();
    }

    public function mount(){
        $this->tickets = auth()->user()->tickets()->latest()->take(5)->get();
    }

    public function render()
    {
        return view('livewire.support.index.recent-tickets-table');
    }
}

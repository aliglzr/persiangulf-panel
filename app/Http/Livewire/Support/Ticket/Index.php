<?php

namespace App\Http\Livewire\Support\Ticket;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public User $user;

    public function mount(){
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('livewire.support.ticket.index');
    }
}

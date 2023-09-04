<?php

namespace App\Http\Livewire\Support\Ticket;

use App\Models\User;
use Livewire\Component;

class TicketsDataTable extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.support.ticket.tickets-data-table');
    }
}

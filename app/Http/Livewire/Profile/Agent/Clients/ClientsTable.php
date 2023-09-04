<?php

namespace App\Http\Livewire\Profile\Agent\Clients;

use App\Models\User;
use Livewire\Component;

class ClientsTable extends Component
{
    public User $user;

    public function mount(User $user){
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.profile.agent.clients.clients-table');
    }

}

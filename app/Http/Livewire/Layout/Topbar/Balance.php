<?php

namespace App\Http\Livewire\Layout\Topbar;

use App\Models\User;
use Livewire\Component;

class Balance extends Component
{
    public User $user;
    public function mount(){
        $this->user = auth()->user();
    }

    public function getListeners()
    {
        return [
            "echo-private:App.Models.User.".$this->user->id.',BalanceUpdated' => '$refresh'
        ];
    }
    public function render()
    {
        return view('livewire.layout.topbar.balance');
    }
}

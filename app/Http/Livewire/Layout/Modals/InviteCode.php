<?php

namespace App\Http\Livewire\Layout\Modals;

use App\Models\User;
use Livewire\Component;

class InviteCode extends Component
{
    public User $user;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('livewire.layout.modals.invite-code');
    }
}

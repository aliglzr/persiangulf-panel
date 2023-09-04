<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use Livewire\Component;

class Logs extends Component
{
    public User $user;
    public function mount(User $user){
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.profile.logs');
    }
}

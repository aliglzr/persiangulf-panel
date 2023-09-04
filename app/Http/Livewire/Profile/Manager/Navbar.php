<?php

namespace App\Http\Livewire\Profile\Manager;

use App\Models\User;
use Livewire\Component;

class Navbar extends Component
{
    public User $user;
    public function mount(User $user){
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.profile.manager.navbar');
    }
}

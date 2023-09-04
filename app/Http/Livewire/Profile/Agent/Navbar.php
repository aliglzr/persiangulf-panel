<?php

namespace App\Http\Livewire\Profile\Agent;

use App\Models\User;
use Livewire\Component;

class Navbar extends Component
{
    public User $user;

    public function mount(User $user){
        $this->user = $user;
    }

    public function login()
    {
        auth()->logout();
        auth()->loginUsingId($this->user->id);
        $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.profile.agent.navbar');
    }
}

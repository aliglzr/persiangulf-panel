<?php

namespace App\Http\Livewire\Profile\Manager\Security;

use App\Models\User;
use Livewire\Component;

class TwoFactorAuthentication extends Component
{
    public User $user;
    protected $listeners = ['2faChanged' => '$refresh'];
    public function mount(User $user){
        $this->user ??= $user;
    }


    public function render()
    {
        return view('livewire.profile.manager.security.two-factor-authentication');
    }
}

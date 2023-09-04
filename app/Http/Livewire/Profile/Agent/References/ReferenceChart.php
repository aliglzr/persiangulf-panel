<?php

namespace App\Http\Livewire\Profile\Agent\References;

use App\Models\User;
use Livewire\Component;

class ReferenceChart extends Component
{
    public User $user;
    public function mount(User $user){
        $this->user ??= $user;
    }
    public function render()
    {
        return view('livewire.profile.agent.references.reference-chart');
    }
}

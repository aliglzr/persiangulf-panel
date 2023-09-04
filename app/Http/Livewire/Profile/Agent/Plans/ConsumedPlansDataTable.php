<?php

namespace App\Http\Livewire\Profile\Agent\Plans;

use App\Models\User;
use Livewire\Component;

class ConsumedPlansDataTable extends Component
{
    public User $user;

    public function mount(User $user){
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.profile.agent.plans.consumed-plans-data-table');
    }
}

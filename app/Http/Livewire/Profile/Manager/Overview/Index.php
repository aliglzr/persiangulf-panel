<?php

namespace App\Http\Livewire\Profile\Manager\Overview;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public User $user;

    public function mount(User $user){
        if (!auth()->user()->isManager()){
            abort(404);
        }
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.profile.manager.overview.index');
    }
}

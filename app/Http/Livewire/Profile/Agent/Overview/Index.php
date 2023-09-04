<?php

namespace App\Http\Livewire\Profile\Agent\Overview;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public User $user;

    public function mount(User $user){
        if (!$user->isAgent()){
            abort(404);
        }
        if (!auth()->user()->isManager()){
            if (auth()->user()->id != $user->id && !auth()->user()->can('view-agent-overview')){
                abort(404);
            }
        }
        $this->user ??= $user;
    }

    public function render()
    {
        return view('livewire.profile.agent.overview.index');
    }
}

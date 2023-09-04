<?php

namespace App\Http\Livewire\Profile\Client\Financial;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public User $user;
    public function mount(User $user){
        if (!$user->isClient()){
            abort(404);
        }
        if (!auth()->user()->isManager() && auth()->user()->id != $user->id && !auth()->user()->can('view-client-financial') && !auth()->user()->introduced()->role('client')->where('id', $user->id)->first()) {
            abort(404);
        }
        $this->user ??= $user;
    }
    public function render()
    {
        return view('livewire.profile.client.financial.index');
    }
}

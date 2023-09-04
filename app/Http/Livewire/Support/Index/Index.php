<?php

namespace App\Http\Livewire\Support\Index;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public User $user;

    public function mount(){
        $this->user = User::find(auth()->user()->id);
    }
    public function render()
    {
        return view('livewire.support.index.index');
    }
}

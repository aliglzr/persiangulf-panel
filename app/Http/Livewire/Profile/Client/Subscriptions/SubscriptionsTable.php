<?php

namespace App\Http\Livewire\Profile\Client\Subscriptions;

use App\Models\User;
use Livewire\Component;

class SubscriptionsTable extends Component
{
    public User $user;
    public function mount(User $user){
        $this->user = $user;
    }
    public function render()
    {
        return view('livewire.profile.client.subscriptions.subscriptions-table');
    }
}

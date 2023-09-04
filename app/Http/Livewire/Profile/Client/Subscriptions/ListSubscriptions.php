<?php

namespace App\Http\Livewire\Profile\Client\Subscriptions;

use App\Models\Plan;
use App\Models\PlanUser;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ListSubscriptions extends Component
{

    public User $user;
    public Collection $subscriptions;

    protected $listeners = ['updateSubscriptions' => '$refresh'];

    public function mount(User $user)
    {
        $this->user = $user;
    }


    public function render()
    {
        return view('livewire.profile.client.subscriptions.list-subscriptions');
    }
}

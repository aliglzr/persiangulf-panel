<?php

namespace App\Http\Livewire\Profile\Agent\Plans;

use App\Models\Plan;
use App\Models\PlanUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ListPlanUsers extends Component
{

    public User $user;
    public Collection $planUsers;

    protected $listeners = ['updatePlanUsers'];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->planUsers = PlanUser::getActivePlanUsers($this->user);
    }

    public function updatePlanUsers(){
        $this->planUsers = PlanUser::getActivePlanUsers($this->user);
    }


    public function render()
    {
        return view('livewire.profile.agent.plans.list-plan-users');
    }
}

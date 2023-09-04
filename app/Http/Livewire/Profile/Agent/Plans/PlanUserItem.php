<?php

namespace App\Http\Livewire\Profile\Agent\Plans;

use App\Models\Plan;
use App\Models\PlanUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Livewire\Component;

class PlanUserItem extends Component {
    public PlanUser $planUser;
    public User $user;
    public int $remainingPercent = 0;

    protected function getListeners() {
        return [
            "updatePlanUser" => 'updatePlanUser'
        ];
    }

    public function updatePlanUser(int $planUserId) {
        if ($this->planUser->id == $planUserId) {
            if ($this->planUser->remaining_user_count) {
                $this->remainingPercent = ($this->planUser->remaining_user_count * 100) / $this->planUser->plan_users_count;
            }
            else{
                $this->emit('updatePlanUsers');
                }
            }
    }


    public function mount(PlanUser $planUser, User $user) {
        $this->planUser = $planUser;
        $this->user = $user;
        $this->remainingPercent = ($this->planUser->remaining_user_count * 100) / $this->planUser->plan_users_count;
    }

    public function getRemainingUsersCountProperty() {
        return$this->planUser->remaining_user_count;
    }

    public function render() {
        return view('livewire.profile.agent.plans.plan-user-item');
    }
}

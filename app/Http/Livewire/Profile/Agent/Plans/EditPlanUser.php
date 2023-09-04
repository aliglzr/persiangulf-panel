<?php

namespace App\Http\Livewire\Profile\Agent\Plans;

use App\Models\PlanUser;
use Livewire\Component;

class EditPlanUser extends Component
{
    public PlanUser $planUser;
    public string $traffic = '';

    protected $listeners = ['editPlanUser' => 'editMode'];

    public function mount(){
        $this->planUser = new PlanUser();
    }

    public function editMode(int $id){
        $this->planUser = PlanUser::find($id);
        $this->traffic = $this->planUser->plan_traffic / (1024 * 1024);
        $this->dispatchBrowserEvent('togglePlanUserModal');
    }

    public function rules(): array
    {
        return [
            'planUser.plan_title' => ['required','string','max:60'],
            'planUser.plan_price' => ['required','numeric'],
            'planUser.plan_sell_price' => ['required','numeric'],
            'planUser.plan_users_count' => ['required','numeric'],
            'planUser.remaining_user_count' => ['required','numeric'],
            'traffic' => ['required','numeric'],
            'planUser.plan_duration' => ['required','numeric'],
            'planUser.active' => ['required','boolean'],
        ];
    }

    public function updatedPlanUserPlanPrice($value){
        $value = preg_replace('/[^0-9.]/', '', $value);
        $this->planUser->plan_price = number_format($value);
    }

    public function updatedPlanUserPlanSellPrice($value){
        $value = preg_replace('/[^0-9.]/', '', $value);
        $this->planUser->plan_sell_price = number_format($value);
    }

    public function updated($field){
        $this->validateOnly($field,$this->rules());
    }

    public function edit(){
        $this->planUser->plan_price = preg_replace('/[^0-9.]/', '', $this->planUser->plan_price);
        $this->planUser->plan_sell_price = preg_replace('/[^0-9.]/', '', $this->planUser->plan_sell_price);
        $this->validate($this->rules());
        $this->planUser->plan_traffic = $this->traffic * (1024 * 1024);
        $this->planUser->save();
        $this->emit('updatePlanUser', $this->planUser->id);
        $this->dispatchBrowserEvent('alert',['type' => 'success', 'message' => 'طرح با موفقیت ویرایش شد']);
        $this->dispatchBrowserEvent('togglePlanUserModal');
        $this->resetModal();
    }

    public function resetModal(){
        $this->resetValidation();
        $this->planUser = new PlanUser();
        $this->planUser->active = 1;
        $this->traffic = 0;
    }

    public function render()
    {
        return view('livewire.profile.agent.plans.edit-plan-user');
    }
}
